<?php

namespace App\Models;

use App\Lib\DatabaseConnection;
use \Ramsey\Uuid\Uuid;

class User {
    public string $userId;
    public string $name;
    public string $size;
    public string $sexe;
    public $weight;
    public $imc;
    public $img;
    public $weight_goal;
    public $imc_goal;
    public $img_goal;
    public string $email;
    public $birthday;
    public $recordDate;
}

class UserModel {

    public DatabaseConnection $connection;

    /**
     * add new user to database
     * @param string $email
     * @param string $password
     * @param string $name
     * @param string $size
     * @param string $sexe
     * @param string $birthday
     * 
     * @return string
     */
    public function createUser(string $email, string $password, string $name, string $size, string $sexe, string $birthday): string {

        $v4 = Uuid::uuid4();
        $newId = $v4->toString();
        $newPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if($sexe === 'man') {
            $newSexe = 1;
        } elseif ($sexe === 'woman') {
            $newSexe = 0;
        }

        $birthDate = str_replace('/', '-', $birthday);
        $newBirthday = date('Y-m-d H:i:s' , strtotime($birthDate));

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO users(userId, email, user_pwd, size, firstname, is_man, birthday, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );

        $affectedLine = $statement->execute([$newId, $email, $newPassword, $size, $name, $newSexe, $newBirthday]);

        if($affectedLine > 0) {
            return $newId;
        } else {
            return "";
        }
    }

    /**
     * verify if user password is ok,
     * if ok get user infos
     * 
     * @param string $email
     * @param string $password
     * 
     * @return array
     */
    public function logUser(string $email, string $password): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM users WHERE email = '$email'"
        );

        $user = $statement->fetch();
        $userInfo = [];

        if($user) {
            if(password_verify($password, $user['user_pwd'])) {
                $userInfo[] = $user['userId'];
                $userInfo[] = $user['firstname'];
                $userInfo[] = $user['size'];
                $userInfo[] = $user['is_man'];
                $userInfo[] = $user['birthday'];
            }
        }

        return $userInfo;

    }

    /**
     * get user stats
     * 
     * @param string $userId
     * 
     * @return User
     */
    public function getStats(string $userId): User {

        $statement = $this->connection->getConnection()->query(
            "SELECT size, firstname, is_man, weight_goal, imc_goal, img_goal, imc, img, user_weight, record_date FROM users RIGHT JOIN goals ON users.userId = goals.userId RIGHT JOIN weight_infos ON users.userId = weight_infos.userId WHERE users.userId = '$userId' AND goals.current = 1 AND weight_infos.record_date = (SELECT MAX(record_date) FROM weight_infos WHERE weight_infos.userId = '$userId')"
        );
        
        $userStats = $statement->fetch();
        
        $userInfos = new User();

        if($userStats > 0) {
            $userInfos->userId = $userId;
            $userInfos->name = $userStats['firstname'];
            $userInfos->size = $userStats['size'];
            if($userStats['is_man'] === 1) {
                $userInfos->sexe = "man";
            } elseif ($userStats['is_man'] === 0) {
                $userInfos->sexe = "woman";
            }
            $userInfos->weight = $userStats['user_weight'];
            $userInfos->imc = number_format($userStats['imc'], 2);
            $userInfos->img = number_format($userStats['img'], 2);
            $userInfos->weight_goal = $userStats['weight_goal'];
            $userInfos->imc_goal = $userStats['imc_goal'];
            $userInfos->img_goal = $userStats['img_goal'];
            $userInfos->recordDate = date('d-m-Y', strtotime($userStats['record_date']));
        }  

        return $userInfos;

    }

    /**
     * get user infos
     * 
     * @param string $userId
     * 
     * @return User
     */
    public function getUserInfos(string $userId): User {

        $statement = $this->connection->getConnection()->query(
            "SELECT firstname, email, size, is_man, birthday FROM users WHERE userId = '$userId'"
        );

        $userProfilInfos = $statement->fetch();

        $userInfos = new User();
        
        if($userProfilInfos > 0) {
            $userInfos->name = $userProfilInfos['firstname'];
            $userInfos->email = $userProfilInfos['email'];
            $userInfos->size = $userProfilInfos['size'];
            $userInfos->birthday = date('d/m/Y', strtotime($userProfilInfos['birthday']));
            if($userProfilInfos['is_man'] === 1) {
                $userInfos->sexe = "man";
            } elseif ($userProfilInfos['is_man'] === 0) {
                $userInfos->sexe = "woman";
            }
        }
            
        return $userInfos ;

    }

}