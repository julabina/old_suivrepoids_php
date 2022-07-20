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
    public $recordDate;
}

class UserModel {

    public DatabaseConnection $connection;

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
            }
        }

        return $userInfo;

    }

    public function getStats($userId): User {

        $statement = $this->connection->getConnection()->query(
            "SELECT size, firstname, is_man, weight_goal, imc_goal, img_goal, imc, img, user_weight, record_date FROM users RIGHT JOIN objectifs ON users.userId = objectifs.userId RIGHT JOIN weight_infos ON users.userId = weight_infos.userId WHERE users.userId = '$userId' AND objectifs.current = 1 AND weight_infos.record_date = (SELECT MAX(record_date) FROM weight_infos)"
        );
        
        $test = $statement->fetch();
        
        $userInfos = new User();

        if($test > 0) {
            $userInfos->userId = $userId;
            $userInfos->name = $test['firstname'];
            $userInfos->size = $test['size'];
            if($test['is_man'] === 1) {
                $userInfos->sexe = "man";
            } elseif ($test['is_man'] === 0) {
                $userInfos->sexe = "woman";
            }
            $userInfos->weight = $test['user_weight'];
            $userInfos->imc = number_format($test['imc'], 2);
            $userInfos->img = number_format($test['img'], 2);
            $userInfos->weight_goal = $test['weight_goal'];
            $userInfos->imc_goal = $test['imc_goal'];
            $userInfos->img_goal = $test['img_goal'];
            $userInfos->recordDate = date('d-m-Y', strtotime($test['record_date']));
        }  

        return $userInfos;

    }

}