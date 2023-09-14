<?php

namespace App\Model\Repository;


use Core\Repository\AppRepoManager;
use Core\Repository\Repository;

class FavoritesRepository extends Repository
{
    public function getTableName(): string
    {
        return 'favorites';
    }

    public function insertEstateToFavorites(array $data)
    {
        $query = sprintf(
            '
            INSERT INTO `%s` 
            (`user_id`, `estate_id`) 
            VALUES 
            (:user_id, :estate_id)',
            $this->getTableName()
        );

        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return false;

        if ($stmt->execute($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Could not add to favorites']);
        }

        return true;
    }

    public function deleteFavorite($user_id, $estate_id): ?bool
    {
        $query = sprintf(
            '
        DELETE FROM %s 
        WHERE user_id = :user_id
        AND estate_id = :estate_id',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        // $stmt->execute([
        //     'user_id' => $user_id,
        //     'estate_id' => $estate_id
        // ]);

        if ($stmt->execute([
            'user_id' => $user_id,
            'estate_id' => $estate_id
        ])) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Could not add to favorites']);
        }

        return true;
    }

    public function findFavoriteByUserId(int $user_id): ?array
    {
        $query = sprintf(
            '
            SELECT *
            FROM `%s`
            WHERE user_id = :user_id',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute(['user_id' => $user_id]);
        $result_array = [];

        while ($row_data = $stmt->fetch()) {
            $result_array[] = $row_data['estate_id'];
        }

        return $result_array;
    }
}
