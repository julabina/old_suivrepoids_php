<?php

namespace App\Models;

use App\Lib\DatabaseConnection;
use \Ramsey\Uuid\Uuid;

class UserModel {

    public DatabaseConnection $connection;

    public function createUser(string $email, string $password, string $name, string $size, string $sexe): bool {

        $v4 = Uuid::uuid4();
        $newId = $v4->toString();
        $newPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $newSexe = false;
        if($sexe === 'men') {
            $newSexe = true;
        } elseif ($sexe === 'women') {
            $newSexe = false;
        }

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO users(userId, email, user_pwd, size, firstname, is_man, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );

        $affectedLine = $statement->execute([$newId, $email, $newPassword, $size, $name, $newSexe]);

        return ($affectedLine > 0);
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

}