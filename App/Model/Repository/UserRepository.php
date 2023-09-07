<?php

namespace App\Model\Repository;

use App\Model\User;
use Core\Repository\Repository;

class UserRepository extends Repository
{
    public function getTableName(): string
    {
        //here we return the name of the table "users" from DB
        return 'user';
    }

    public function checkAuth(string $email, string $password)
    {
        $query = sprintf(
            '
            SELECT 
                * 
            FROM 
                %s 
            WHERE 
                email = :email 
            AND 
                password = :password',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute([
            'email' => $email,
            'password' => $password
        ]);
        $user_data = $stmt->fetch();

        return empty($user_data) ? null : new User($user_data);
    }

    public function checkIfUserExists(string $email): bool
    {
        $query = sprintf(
            '
            SELECT 
                * 
            FROM 
                %s 
            WHERE 
                email = :email',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'email' => $email,
        ]);
        $user_data = $stmt->fetch();
        if ($user_data) {
            return true;
        } else {
            return false;
        }
    }

    public function addNewUser(array $data): bool
    {
        $query = sprintf(
            '
            INSERT INTO 
                `%s` 
            (`first_name`, `second_name`, `email`, `password`, `photo_user`) 
            VALUES (:first_name, :second_name, :email, :password, :photo_user)',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return false;
        $stmt->execute($data);
        return true;
    }
}
