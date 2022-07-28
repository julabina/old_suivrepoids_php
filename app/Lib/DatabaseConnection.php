<?php

namespace App\Lib;

class DatabaseConnection {

    private ?\PDO $database = null;

    /**
     * create a PDO connection to database
     * @return PDO
     */
    public function getConnection(): \PDO {

        if($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=weight_tracker;charset=utf8', 'root', '');
        }

        return $this->database;

    }

}