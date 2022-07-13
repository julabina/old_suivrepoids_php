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

}