<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Models\UserModel;

class UserController {

    public function sign() {

        if(
            (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && 
            (isset($_POST['password']) && $_POST['password'] !== "" && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['password'])) &&
            (isset($_POST['name']) && $_POST['name'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['name']) && (strlen($_POST['name']) > 2 || strlen($_POST['name']) < 25)) &&
            (isset($_POST['size']) && preg_match('/^[0-9]*$/', $_POST['size']) && ($_POST['size'] > 90 && $_POST['size'] < 260)) && 
            (isset($_POST['sexe']) && ($_POST['sexe'] === "men" || $_POST['sexe'] === "women"))
        ) {
            
            $email = $_POST['email'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $size = $_POST['size'];
            $sexe = $_POST['sexe'];
            
            $userModel = new UserModel();
            $userModel->connection = new DatabaseConnection();
            
            $success = $userModel->createUser($email, $password, $name, $size, $sexe);
            
            if($success) {
                $this->log();
            } else {
                echo 'pas ok';
            }
        }

    }

    public function log() {

            if(
                (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && 
                (isset($_POST['password']) && $_POST['password'] !== "" && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['password']))
            ) {

                $email = $_POST['email'];
                $password = $_POST['password'];

                $userModel = new UserModel();
                $userModel->connection = new DatabaseConnection();

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
                } 

            }
        
            header('Location: /suivi_poids/');

    }

}