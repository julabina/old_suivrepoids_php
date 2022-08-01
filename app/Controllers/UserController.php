<?php

namespace App\Controllers;

use App\Lib\Jwt;
use App\Models\UserModel;
use App\Models\StatsModel;

class UserController {

    /**
     * create user account
     */
    public function sign() {

        if(
            (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && 
            (isset($_POST['password']) && $_POST['password'] !== "" && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['password'])) &&
            (isset($_POST['name']) && $_POST['name'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['name']) && (strlen($_POST['name']) > 2 || strlen($_POST['name']) < 25)) &&
            (isset($_POST['size']) && preg_match('/^[0-9]*$/', $_POST['size']) && ($_POST['size'] > 90 && $_POST['size'] < 260)) && 
            (isset($_POST['weight']) && preg_match('/^[0-9]*$/', $_POST['weight']) && ($_POST['weight'] > 30 && $_POST['weight'] < 250)) && 
            (isset($_POST['sexe']) && ($_POST['sexe'] === "man" || $_POST['sexe'] === "woman")) &&
            (isset($_POST['birthday']) && preg_match('/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)(?:19\d{2}|20[01][0-9]|2022)$/i', $_POST['birthday']))
        ) {

            foreach ($_POST as $element => $val) {

                $_POST[$element] = htmlspecialchars($val);
            
            }
            
            $email = $_POST['email'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $size = $_POST['size'];
            $weight = $_POST['weight'];
            $sexe = $_POST['sexe'];
            $birthday = $_POST['birthday'];
            $age = 30;
            
            $userModel = new UserModel();
            
            $id = $userModel->createUser($email, $password, $name, $size, $sexe, $birthday);
            
            if($id === "errSign") {
                header('Location: /suivi_poids/sign?err=email');
            } elseif($id !== "") {
                $statModel = new StatsModel();

                $addingWeight = $statModel->addWeight($weight, $size, null, $sexe, $age, $id);
                $addingGoal = $statModel->addGoal($id, NULL, NULL, NULL);
                $this->log();
            } else {
                header('Location: /suivi_poids/sign?err=sign');
            }
        } else {
            header('Location: /suivi_poids/sign?err=format');
        }

    }

    /**
     * log one user,
     * create php session if ok
     */
    public function log() {

            if(
                (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && 
                (isset($_POST['password']) && $_POST['password'] !== "" && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['password']))
            ) {

                foreach ($_POST as $element => $val) {

                    $_POST[$element] = htmlspecialchars($val);
                
                }

                $email = $_POST['email'];
                $password = $_POST['password'];

                $userModel = new UserModel();

                $user = $userModel->logUser($email, $password);

                if(sizeof($user) > 0) {
                    SESSION_START();
                    $_SESSION['user'] = $email;
                    $_SESSION['name'] = $user[1];
                    $_SESSION['size'] = $user[2];
                    if($user[3] === 1) {
                        $_SESSION['sexe'] = "man";
                    } else if ($user[3] === 0) {
                        $_SESSION['sexe'] = "woman";
                    }
                    $_SESSION['userId'] = $user[0];
                    $_SESSION['auth'] = true;
                    $_SESSION['birthday'] = $user[4];
                    
                    $jwt = new Jwt();
                    $token = $jwt->createToken($user[0]);
                    $_SESSION['token'] = $token;

                    header('Location: /suivi_poids');
                } else {

                    header('Location: /suivi_poids/login?err=log');

                }

            } else {

                header('Location: /suivi_poids/login?err=format');
            
            }
            

    }

    /**
     * disconnect user and clear php session
     */
    public function logout($err = "") {

        session_start();
        
        $_SESSION = array();

        session_destroy();

        if($err === "") {
            header('Location: /suivi_poids/');
        } else {
            header('Location: /suivi_poids/login?err=' . $err);
        }


    }

    /**
     * open the user dashboard if user is logged
     */
    public function showDash() {

        SESSION_START();

        if(!isset($_SESSION['name']) || !isset($_SESSION['token']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }

        foreach ($_POST as $element => $val) {

            $_POST[$element] = htmlspecialchars($val);
        
        }
        
        $userModel = new UserModel();
        $userData = $userModel->getStats(htmlspecialchars($_SESSION['userId']));
        $userWeightList = $userModel->getAllWeight(htmlspecialchars($_SESSION['userId']));   
        
        
        if(!isset($userData->userId)) {
           
        }
        
        require('templates/dashboard.php');

    }

    /**
     * Open the user profil page
     */
    public function showProfil() {

        SESSION_START();

        if(!isset($_SESSION['name']) || !isset($_SESSION['token']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }

        foreach ($_POST as $element => $val) {

            $_POST[$element] = htmlspecialchars($val);
        
        }

        $userModel = new UserModel();
        $userInfos = $userModel->getUserInfos(htmlspecialchars($_SESSION['userId']));

        var_dump($userInfos);
        require('templates/profil.php');
    }


    /**
     * delete user account
     */
    public function deleteUser() {

        SESSION_START();
        
        if(!isset($_SESSION['name']) || !isset($_SESSION['token']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }

        foreach ($_POST as $element => $val) {

            $_POST[$element] = htmlspecialchars($val);
        
        }
        
        $jwt = new Jwt();
        $id = htmlspecialchars($_SESSION['userId']);
        $token = $_POST['token'];
        
        if(!$jwt->isValid($token)) {
            http_response_code(400);
            return $this->logout("format");
        }
        if(!$jwt->check($token)) {
            http_response_code(403);
            return $this->logout("format");
        }
        if($jwt->isExpired($token)) {
            http_response_code(403);
            return $this->logout("exp");
        }
        
        $payload = $jwt->getPayload($token);
        
        if($id === $payload['userId']) {
            
            $userModel = new UserModel();
            $success = $userModel->deleteUser(htmlspecialchars($_SESSION['userId']));
            
            if($success) {
                $this->logout("delete");
            } else {
                $this->logout("format");
            }
            
        } else {
            http_response_code(400);
            $this->logout("format");
        }
        
    }
    
    /**
     * modify user profil
     */
    public function modifyProfil(){
        
        SESSION_START();
        
        if(!isset($_SESSION['name']) || !isset($_SESSION['token']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }

        foreach ($_POST as $element => $val) {

            $_POST[$element] = htmlspecialchars($val);
        
        }

        $jwt = new Jwt();
        $id = htmlspecialchars($_SESSION['userId']);
        $token = $_POST['token'];
        
        if(!$jwt->isValid($token)) {
            http_response_code(400);
            return header('Location: /suivi_poids/profil?err=format');
        }
        if(!$jwt->check($token)) {
            http_response_code(403);
            return header('Location: /suivi_poids/profil?err=format');
        }
        if($jwt->isExpired($token)) {
            http_response_code(403);
            return $this->logout("exp");
        }
        
        $payload = $jwt->getPayload($token);
        
        if($id === $payload['userId']) {
            
            if(
                (isset($_POST['name']) && $_POST['name'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['name']) && (strlen($_POST['name']) > 2 || strlen($_POST['name']) < 25)) &&
                (isset($_POST['size']) && preg_match('/^[0-9]*$/', $_POST['size']) && ($_POST['size'] > 90 && $_POST['size'] < 260)) && 
                (isset($_POST['sexe']) && ($_POST['sexe'] === "man" || $_POST['sexe'] === "woman")) &&
                (isset($_POST['birthday']) && preg_match('/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)(?:19\d{2}|20[01][0-9]|2022)$/i', $_POST['birthday']))
            ) {            
                $userModel = new UserModel();
                $success = $userModel->modifyUser(htmlspecialchars($_SESSION['userId']), $_POST['name'], $_POST['size'], $_POST['sexe'], $_POST['birthday']); 
                
                if($success){
                    header('Location: /suivi_poids/profil?success=true');
                } else {
                    header('Location: /suivi_poids/profil?success=false');
                }
            }
            
        } else {
            http_response_code(400);
            $this->logout('format');
        }

        
    }

    /**
     * Modify user password
     */
    public function modifyPassword() {
        
        SESSION_START();
        
        if(!isset($_SESSION['name']) || !isset($_SESSION['token']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }

        foreach ($_POST as $element => $val) {

            $_POST[$element] = htmlspecialchars($val);
        
        }

        $jwt = new Jwt();
        $id = htmlspecialchars($_SESSION['userId']);
        $token = $_POST['token'];
        
        if(!$jwt->isValid($token)) {
            http_response_code(400);
            return header('Location: /suivi_poids/profil?err=format');
        }
        if(!$jwt->check($token)) {
            http_response_code(403);
            return header('Location: /suivi_poids/profil?err=format');
        }
        if($jwt->isExpired($token)) {
            http_response_code(403);
            return $this->logout("exp");
        }
        
        $payload = $jwt->getPayload($token);
        
        if($id === $payload['userId']) {
            
            if(
                (isset($_POST['oldPassword']) && $_POST['oldPassword'] !== "" && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['oldPassword'])) &&
                (isset($_POST['newPassword']) && $_POST['newPassword'] !== "" && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['newPassword']))
            ) {
 
                $userModel = new UserModel();
                $success = $userModel->modifyUserPassword(htmlspecialchars($_SESSION['userId']), $_POST['oldPassword'], $_POST['newPassword']); 
                
                if($success){
                    return header('Location: /suivi_poids/profil?success=true');
                } else {
                    return header('Location: /suivi_poids/profil?success=false');
                }     
            }
            
            header('Location: /suivi_poids/profil?success=false');
            
        } else {
            http_response_code(400);
            $this->logout('format');
        }

    }

}