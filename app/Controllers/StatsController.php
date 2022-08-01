<?php

namespace App\Controllers;

use App\Models\StatsModel;
use App\Lib\Jwt;
use App\Controllers\UserController;


class StatsController {

    /**
     * open goal page and display goal
     */
    public function showGoals() {

        SESSION_START();

        if(!isset($_SESSION['name']) || !isset($_SESSION['token']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }
        
        $id = htmlspecialchars($_SESSION['userId']);
        
        $statsModel = new StatsModel();
        $goals = $statsModel->getAllGoals($id);
        
        require('templates/goals.php');
        
    }
    
    /**
     * add user new goal
     */
    public function addGoal() {
        
        SESSION_START();
        
        if(!isset($_SESSION['name']) || !isset($_SESSION['token']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }

        foreach ($_POST as $element => $val) {

            $_POST[$element] = htmlspecialchars($val);
        
        }

        $userController = new UserController();

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
            return $userController->logout("exp");
        }
        
        $payload = $jwt->getPayload($token);
        
        if($id === $payload['userId']) {
            
            $weight = NULL;
            $bmi = NULL;
            $img = NULL;
            
            if(isset($_POST['objChangeWeight'])) {
                if($_POST['objChangeWeight'] !== "" && preg_match('/^[0-9]*$/', $_POST['objChangeWeight']) && ($_POST['objChangeWeight'] > 30 && $_POST['objChangeWeight'] < 250)) {
                    $weight = $_POST['objChangeWeight'];
                }
            } else if(isset($_POST['objChangeImc'])) {
                if($_POST['objChangeImc'] !== "" && preg_match('/^[0-9]*$/', $_POST['objChangeImc']) && ($_POST['objChangeImc'] > 10 && $_POST['objChangeImc'] < 80)) {
                    $bmi = $_POST['objChangeImc'];
                }
            } else if(isset($_POST['objChangeImg'])) {
                if($_POST['objChangeImg'] !== "" && preg_match('/^[0-9]*$/', $_POST['objChangeImg']) && ($_POST['objChangeImg'] > 10 && $_POST['objChangeImg'] < 80)) {
                    $img = $_POST['objChangeImg'];
                }
            } else {
                return header('Location: /suivi_poids/');
            }
            
            $statsModel = new StatsModel();
            $success = $statsModel->addGoal(htmlspecialchars($_SESSION['userId']), $weight, $bmi, $img);
            
            if($success) {
                header('Location: /suivi_poids/dashboard');
            } else {
                header('Location: /suivi_poids/objectifs?err=obj');
            }
            
        } else {
            http_response_code(400);
            $userController->logout("format");
        }
        
    }
    
    /**
     * open imc page
     */
    public function showImc() {

        SESSION_START();
        
        if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && isset($_SESSION['auth'])) && $_SESSION['auth'] === true) {
            
            $statsModel = new StatsModel();
            $imcInfos = $statsModel->getImc(htmlspecialchars($_SESSION['userId']));
            
        }
        
        require('templates/imc.php');
    }
    
    /**
     * open img page
     */
    public function showImg() {
        
        SESSION_START();

        if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
            
            $statsModel = new StatsModel();
            $imgInfos = $statsModel->getImg(htmlspecialchars($_SESSION['userId']));
            
        }

        require('templates/img.php');
    }

    /**
     * add user new weight
     */
    public function addWeight() {

        SESSION_START();
        
        if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true && isset($_SESSION['birthday'])) {
            
            foreach ($_POST as $element => $val) {
                $_POST[$element] = htmlspecialchars($val);
            }

            $jwt = new Jwt();
            $id = htmlspecialchars($_SESSION['userId']);
            $token = $_POST['token'];
            $userController = new UserController();
            
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
                return $userController->logout("exp");
            }
            
            $payload = $jwt->getPayload($token);
            
            if($id === $payload['userId']) {
                
                if(isset($_POST['addWeight']) && $_POST['addWeight'] !== "" && ($_POST['addWeight'] < 261 && $_POST['addWeight'] > 29)) {
    
                    $newWeight = $_POST['addWeight'];
    
                    $statsModel = new StatsModel();
                    $success = $statsModel->addWeight($newWeight,htmlspecialchars($_SESSION['size']) , null, htmlspecialchars($_SESSION['sexe']), htmlspecialchars($_SESSION['birthday']) ,htmlspecialchars($_SESSION['userId']));
    
                    if($success) {   
                        header('Location: /suivi_poids/dashboard');         
                    } else {
                        header('Location: /suivi_poids/dashboard?err=addW');
                    }
                    
                }                
                
            } else {
                http_response_code(400);
                $userController->logout("format");
            }


        } 

    }

}