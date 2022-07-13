<?php

namespace App\Models;

use App\Lib\DatabaseConnection;
use \DateTime;
use \Ramsey\Uuid\Uuid;

class StatsModel {

    public DatabaseConnection $connection;

    public function addWeight($weight, $size, $recordDate, $sexe, $age, $id) {

        $v4 = Uuid::uuid4();
        $newId = $v4->toString();

        if($recordDate === NULL) {
            $date = new \DateTime();
            var_dump($date);
            echo $date->format('Y-m-d H:i:s');
        } else {
            $date = "";
        }

        $imc = $this->getImc($weight, $size);
        $img = $this->getImg($sexe, $imc, $age);

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO weight_infos(id, userId, user_weight, imc, img, record_date, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );

        $affectedLine = $statement->execute([$newId, $id, $weight, $imc, $img, $date->format('Y-m-d H:i:s')]);

        return ($affectedLine > 0);
        
    }
    
    public function addObjectif($userId) {
        
        $v4 = Uuid::uuid4();
        $newId = $v4->toString();
        
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO objectifs(id, userId, weight_goal, imc_goal, img_goal, current, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );
        
        $affectedLine = $statement->execute([$newId, $userId, NULL, NULL, NULL, 1]);
        
        return ($affectedLine > 0);

    }

    public function getAllObjectif($userId) {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM objectifs WHERE userId = '$userId'"
        );

        $objectifs = [];

        while(($row = $statement->fetch())) {
            $objectifs[] = $row;
        }

        return $objectifs;

    }

    private function getImc($weight, $size) {
        $newSize = $size / 100;
        return number_format($weight / ($newSize*$newSize), 2);
    }

    private function getImg($sexe, $imc, $age) {

        $newImc = number_format($imc, 0);

        if ($sexe === "man") {
            return (1.2*$newImc)+(0.23*$age)-(10.8*1)-5.4;
        } else  if ($sexe === "woman") {
            return (1.2*$newImc)+(0.23*$age)-(10.8*0)-5.4;
        }
    }

}