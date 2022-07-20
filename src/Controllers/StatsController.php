<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Models\StatsModel;

class StatsController {

    public function showObjectif() {

        SESSION_START();

        if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }
        
        $id = $_SESSION['userId'];
        
        $statsModel = new StatsModel();
        $statsModel->connection = new DatabaseConnection();
        $objectifs = $statsModel->getAllObjectif($id);
        
        require('templates/objectif.php');
        
    }
    
    public function addObjectif() {
        
        SESSION_START();
        
        if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            return header('Location: /suivi_poids/login');
        }
        
        $weight = NULL;
        $imc = NULL;
        $img = NULL;
        
        if(isset($_POST['objChangeWeight'])) {
            if($_POST['objChangeWeight'] !== "" && preg_match('/^[0-9]*$/', $_POST['objChangeWeight']) && ($_POST['objChangeWeight'] > 30 && $_POST['objChangeWeight'] < 250)) {
                $weight = $_POST['objChangeWeight'];
            }
        } else if(isset($_POST['objChangeImc'])) {
            if($_POST['objChangeImc'] !== "" && preg_match('/^[0-9]*$/', $_POST['objChangeImc']) && ($_POST['objChangeImc'] > 10 && $_POST['objChangeImc'] < 80)) {
                $imc = $_POST['objChangeImc'];
            }
        } else if(isset($_POST['objChangeImg'])) {
            if($_POST['objChangeImg'] !== "" && preg_match('/^[0-9]*$/', $_POST['objChangeImg']) && ($_POST['objChangeImg'] > 10 && $_POST['objChangeImg'] < 80)) {
                $img = $_POST['objChangeImg'];
            }
        } else {
            header('Location: /suivi_poids/');
        }
        
        $statsModel = new StatsModel();
        $statsModel->connection = new DatabaseConnection();
        $success = $statsModel->addObjectif($_SESSION['userId'], $weight, $imc, $img);
        
        if($success) {
            header('Location: /suivi_poids/objectifs');
        } else {
            header('Location: /suivi_poids/objectifs');
        }
    }
    
    public function showImc() {

        SESSION_START();
        
        if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && isset($_SESSION['auth'])) && $_SESSION['auth'] === true) {
            
            $statsModel = new StatsModel();
            $statsModel->connection = new DatabaseConnection();
            $imcInfos = $statsModel->getImc($_SESSION['userId']);
            
        }
        
        require('templates/imc.php');
    }
    
    public function showImg() {
        
        SESSION_START();

        if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
            
            $statsModel = new StatsModel();
            $statsModel->connection = new DatabaseConnection();
            $imgInfos = $statsModel->getImg($_SESSION['userId']);
            
        }

        require('templates/img.php');
    }

}