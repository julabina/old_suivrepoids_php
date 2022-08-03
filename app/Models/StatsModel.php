<?php

namespace App\Models;

use App\Lib\DatabaseConnection;
use \DateTime;
use \Ramsey\Uuid\Uuid;

class StatsModel extends DatabaseConnection {

    /**
     * add new weight to one user
     * @param string $weight
     * @param string $size
     * @param $recordedDate
     * @param string $sexe
     * @param string $birthdate
     * @param string $id
     * @return boolean
     */
    public function addWeight(string $weight, string $size, $recordDate, string $sexe, string $birthDate, string $id): bool {

        $v4 = Uuid::uuid4();
        $newId = $v4->toString();

        if($recordDate === NULL) {
            $date = new \DateTime();
        } else {
            $date = "";
        }

        $birthdayTimestamp = strtotime($birthDate);
        $currentDate = time();
        $birthToNow = $currentDate - $birthdayTimestamp;
        $age = floor($birthToNow / 31536000);

        $imc = $this->calculBmi($weight, $size);
        $img = $this->calculBfp($sexe, $imc, $age);

        $statement = $this->getConnection()->prepare(
            "INSERT INTO weight_infos(id, userId, user_weight, imc, img, record_date, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );

        $affectedLine = $statement->execute([$newId, $id, $weight, $imc, $img, $date->format('Y-m-d H:i:s')]);

        return ($affectedLine > 0);
        
    }
    
    /**
     * add new goal to one user
     * @param string $userId
     * @param $weight
     * @param $imc
     * @param $img
     * @return boolean
     */
    public function addGoal(string $userId, $weight, $imc, $img): bool {

        $success = $this->removeCurrent($userId);

        if($success) {
            
            $v4 = Uuid::uuid4();
            $newId = $v4->toString();
            
            $statement = $this->getConnection()->prepare(
                "INSERT INTO goals(id, userId, weight_goal, imc_goal, img_goal, current_goal, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())"
            );
            
            $affectedLine = $statement->execute([$newId, $userId, $weight, $imc, $img, 1]);
            
            return ($affectedLine > 0);
            
        } else {
            return false;
        }
        
    }
    
    /**
     * remove from last goal the current status
     * @param string $userId
     * @return boolean
     */
    private function removeCurrent(string $userId): bool {
        
        $statement = $this->getConnection()->prepare(
            "UPDATE goals SET current_goal = ? WHERE userId = ?"
        );
        
        $affectedLine = $statement->execute([0, $userId]);

        return ($affectedLine > 0);

    }

    /**
     * get all user goals
     * @param string $userId
     * @return array
     */
    public function getAllGoals(string $userId): array {

        $statement = $this->getConnection()->query(
            /* "SELECT * FROM goals WHERE userId = '$userId' ORDER BY created_at DESC" */
            "SELECT goals.id, weight_goal, imc_goal, img_goal, current_goal, success, goals.created_at, user_weight, imc, img, record_date FROM goals LEFT JOIN weight_infos ON goals.userId = weight_infos.userId WHERE goals.userId = '$userId' AND weight_infos.record_date = (SELECT MAX(record_date) FROM weight_infos WHERE weight_infos.userId = '$userId') ORDER BY goals.created_at DESC; "
        );

        $goals = [];

        while(($row = $statement->fetch())) {
            $goals[] = $row;
        }

        return $goals;

    }

    /**
     * get user bmi
     * @param string $userId
     * @return array
     */
    public function getImc(string $userId): array {

        $statement = $this->getConnection()->query(
            "SELECT size, user_weight FROM users RIGHT JOIN weight_infos ON users.userId = weight_infos.userId WHERE users.userId = '$userId' AND weight_infos.record_date = (SELECT MAX(record_date) FROM weight_infos WHERE weight_infos.userId = '$userId')"
        );

        $userInfos = $statement->fetch();

        $imc = $this->calculBmi($userInfos['user_weight'], $userInfos['size']);
        
        $imcArr = ["imc" => $imc];

        return $userImcInfos = $userInfos + $imcArr;

    }

    /**
     * get user bfp 
     * @param string $userId
     * @return array
     */
    public function getImg(string $userId): array {

        $statement = $this->getConnection()->query(
            "SELECT size, is_man, birthday, user_weight FROM users RIGHT JOIN weight_infos ON users.userId = weight_infos.userId WHERE users.userId = '$userId' AND weight_infos.record_date = (SELECT MAX(record_date) FROM weight_infos WHERE weight_infos.userId = '$userId')"
        );

        $userInfos = $statement->fetch();

        $imc = $this->calculBmi($userInfos['user_weight'], $userInfos['size']);

        if($userInfos['is_man'] === 1) {
            $sexe = "man";
        } else {
            $sexe = "woman";
        } 

        $birthdayTimestamp = strtotime($userInfos['birthday']);
        $currentDate = time();
        $birthToNow = $currentDate - $birthdayTimestamp;
        $age = floor($birthToNow / 31536000);
        
        $img = $this->calculBfp($sexe, $imc, $age);

        $imgArr = ["img" => $img];
        $ageArr = ["age" => $age];

        return $userImgInfos = $userInfos + $imgArr + $ageArr;

    }

    /**
     * calcul the user bmi
     * @param string $weight
     * @param string $size
     * @return int
     */
    private function calculBmi(string $weight, string $size): int {
        
        $newSize = $size / 100;
        
        return number_format($weight / ($newSize*$newSize), 2);
    }

    /**
     * calcul the user bfp
     * @param string $sexe
     * @param string $imc
     * @param string $age
     * @return int
     */
    private function calculBfp(string $sexe, string $imc, string $age): int {

        $newImc = number_format($imc, 0);

        if ($sexe === "man") {
            return (1.2*$newImc)+(0.23*$age)-(10.8*1)-5.4;
        } else  if ($sexe === "woman") {
            return (1.2*$newImc)+(0.23*$age)-(10.8*0)-5.4;
        }
    }

    /**
     * if weight is not the current, 
     * delete weight
     * @param string $id
     * @param string $userId
     * @return string
     */
    public function deleteWeight(string $id, string $userId): string {

        $connect = $this->getConnection();

        $checkStatement = $connect->query(
            "SELECT id FROM weight_infos WHERE record_date = (SELECT MAX(record_date) FROM weight_infos WHERE weight_infos.userId = '$userId')"
        );

        $currentId = $checkStatement->fetch();
        
        if($id !== $currentId['id']) {
            $statement = $connect->prepare(
                "DELETE FROM weight_infos WHERE weight_infos.id = ?"
            );

            $affectedLine = $statement->execute([$id]);

            if($affectedLine > 0) {
                return "ok";
            } else {
                return "notOk";
            }

        } else {
            return "first";
        }

    }

}