<?php

namespace App\Models;

use App\Lib\DatabaseConnection;
use \Ramsey\Uuid\Uuid;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

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

class WeightData {
    public string $id;
    public string $weight;
    public string $bmi;
    public string $bfp;
    public string $recordDate;
}

class UserModel extends DatabaseConnection {

    /**
     * add new user to database
     * @param string $email
     * @param string $password
     * @param string $name
     * @param string $size
     * @param string $sexe
     * @param string $birthday
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

        $connection = $this->getConnection();

        $userStatement = $connection->query(
            "SELECT * FROM users WHERE email = '$email'"
        );

        $user = $userStatement->fetch();
        
        if($user === false) {

            $statement = $connection->prepare(
                "INSERT INTO users(userId, email, user_pwd, size, firstname, is_man, birthday, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
            );
    
            $affectedLine = $statement->execute([$newId, $email, $newPassword, $size, $name, $newSexe, $newBirthday]);
    
            if($affectedLine > 0) {
                return $newId;
            } else {
                return "";
            }

        } else {
            return "errSign";
        }

    }

    /**
     * verify if user password is ok,
     * if ok get user infos
     * @param string $email
     * @param string $password
     * @return array
     */
    public function logUser(string $email, string $password): array {

        $statement = $this->getConnection()->query(
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
     * @param string $userId
     * @return User
     */
    public function getStats(string $userId): User {

        $statement = $this->getConnection()->query(
            "SELECT size, firstname, is_man, weight_goal, imc_goal, img_goal, imc, img, user_weight, record_date FROM users RIGHT JOIN goals ON users.userId = goals.userId RIGHT JOIN weight_infos ON users.userId = weight_infos.userId WHERE users.userId = '$userId' AND goals.current_goal = 1 AND weight_infos.record_date = (SELECT MAX(record_date) FROM weight_infos WHERE weight_infos.userId = '$userId')"
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
     * @param string $userId
     * @return User
     */
    public function getUserInfos(string $userId): User {

        $statement = $this->getConnection()->query(
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
 
    /**
     * delete user account
     * @param string $userId
     * @return boolean
     */
    public function deleteUser(string $userId): bool {

        $connect = $this->getConnection();

        $statement = $connect->prepare(
            "DELETE FROM users WHERE users.userId = ?"            
        );

        $affectedLine = $statement->execute([$userId]);
        
        if($affectedLine > 0) {
            $statement2 = $connect->prepare(
                "DELETE FROM goals WHERE goals.userId = ?"            
            );
            $statement3 = $connect->prepare(
                "DELETE FROM weight_infos WHERE weight_infos.userId = ?"            
            );
            $affectedLine = $statement2->execute([$userId]);
            $affectedLine = $statement3->execute([$userId]);
        }

        return ($affectedLine > 0);

    }

    /**
     * modify user infos like name, size, sexe and bithday
     * @param string $userId
     * @param string $name
     * @param string $size
     * @param string $sexe
     * @param string $birthday
     */
    public function modifyUser(string $userId, string $name, string $size, string $sexe, string $birthday) {

        if($sexe === 'man') {
            $newSexe = 1;
        } elseif ($sexe === 'woman') {
            $newSexe = 0;
        }

        $birthDate = str_replace('/', '-', $birthday);
        $newBirthday = date('Y-m-d H:i:s' , strtotime($birthDate));

        $statement = $this->getConnection()->prepare(
            "UPDATE users SET size = ?, firstname = ?, is_man = ?, birthday = ? WHERE userId = ?"
        );

        $affectedLine = $statement->execute([$size, $name, $newSexe, $newBirthday, $userId]);

        return ($affectedLine > 0);

    }

    /**
     * update user password
     * @param string $userId
     * @param string $old
     * @param string $new
     * @return boolean
     */
    public function modifyUserPassword($userId, $old, $new): bool {

        $connect = $this->getConnection();

        $firstStatement = $connect->query(
            "SELECT user_pwd FROM users WHERE userId = '$userId'"
        );

        $user = $firstStatement->fetch();

        if(password_verify($old, $user['user_pwd'])) {
            
            $newPassword = password_hash($new, PASSWORD_DEFAULT);

            $statement = $connect->prepare(
                "UPDATE users SET user_pwd = ? WHERE users.userId = ?"
            );

            $affectedLine = $statement->execute([$newPassword, $userId]);

            return ($affectedLine > 0);

        } else {
            return false;
        }

    }

    /**
     * get all weight for one user
     * @param string $userId
     * @return array
     */
    public function getAllWeight(string $userId): array {

        $statement = $this->getConnection()->query(
            "SELECT id, user_weight, imc, img, record_date FROM weight_infos WHERE userId = '$userId' ORDER BY record_date DESC"
        );

        $weightData = [];

        while(($row = $statement->fetch())) {

            $data = new WeightData();
            $data->id = $row['id'];
            $data->weight = $row['user_weight'];
            $data->bmi = $row['imc'];
            $data->bfp = $row['img'];
            $data->recordDate = $row['record_date'];

            $weightData[] = $data;
        }

        return $weightData;

    }

    /**
     * Send email to webmaster
     * @param string $email
     * @param string $name
     * @param string $subject
     * @param string $msg
     * @return boolean
     */
    public function sendMail(string $email, string $name, string $subject, string $msg): bool {

        $mail = new PHPMailer();
        $mainSubject = "Suivi poids - " . $subject;
        $message = "From: " . $name . " , Email: " . $email . " , Message: " . $msg;

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_ACC'];
            $mail->Password = $_ENV['GMAIL_PWD'];

            $mail->setFrom($_ENV['GMAIL_ACC'], 'Suivi poids');
            $mail->addAddress($_ENV['GMAIL_ACC']);
            $mail->addReplyTo($email);
            
            $mail->Subject = $mainSubject;
            $mail->Body = $message;

            if(!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch(Exception $e) {
            return false /* $mail->ErrorInfo */;
        }

    }

    /**
     * check if user exist
     * if ok change the password
     * and send email with him
     * 
     * @param string $email
     * @return string
     */
    public function resetPwd(string $email): string {

        $connect = $this->getConnection();

        $statement = $connect->query(
            "SELECT * FROM users WHERE email = '$email'"
        );

        $user = $statement->fetch();

        if($user > 0) {

            $newPassword = ""; 
            
            do{
                $newPassword = $this->randPwd();
            }while(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $newPassword));
            
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $pwdStatement = $connect->prepare(
                "UPDATE users SET user_pwd = ? WHERE users.email = ?"
            );

            $affectedLine = $pwdStatement->execute([$newPasswordHash, $email]);

            if($affectedLine > 0) {
                $mail = new PHPMailer();
                $mainSubject = "Suivi poids - Reinitialisation du mot de passe";
                $message = "Votre nouveau mot de passe est: $newPassword";
        
                try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $_ENV['GMAIL_ACC'];
                    $mail->Password = $_ENV['GMAIL_PWD'];
        
                    $mail->setFrom($_ENV['GMAIL_ACC'], 'Suivi poids');
                    $mail->addAddress("julabina@hotmail.fr");
                    
                    $mail->Subject = $mainSubject;
                    $mail->Body = $message;
        
                    if(!$mail->send()) {
                        return "false";
                    } else {
                        return "true";
                    }
                } catch(Exception $e) {
                    return "false"  /*$mail->ErrorInfo */;
                } 
            }  else {
                return "false";
            } 
            
        } else {
            return "notExist";
        }
    }

    /**
     * generate random password
     * @return string
     */
    private function randPwd(): string {

        $pwdLength = rand(8, 15);
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($char);    
        
        $pwd = "";

        for($i = 0; $i < $pwdLength; $i++) {
            $pwd .= $char[rand(0, $charLength - 1)];
        }

        return $pwd;
    }

}