<?php

namespace App\Model\Repository;


use App\Model\Estate;
use App\Model\Favorites;
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

    public function findFavoriteByUserIdWithModels(int $id): ?array
    {
        $query = sprintf(
            '
            SELECT `%1$s`.*, `%2$s`.city, `%2$s`.country, `%2$s`.size, `%2$s`.price, `%2$s`.allowed_animals, `%2$s`.num_beds
            FROM `%1$s` 
            INNER JOIN `%2$s` ON `%2$s`.id = `%1$s`.estate_id
            WHERE `%1$s`.user_id = :user_id',
            $this->getTableName(),
            AppRepoManager::getRm()->getEstateRepo()->getTableName()
        );

        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute(['user_id' => $id]);
        $result_array = [];

        while ($row_data = $stmt->fetch()) {
            $favorite = new Favorites($row_data);
            $favorite->photos =
                AppRepoManager::getRm()->getPhotoEstateRepo()->findAllPhotosByEstateId($row_data['estate_id']);
            $data_estate = [
                'id' => $row_data['estate_id'],
                'city' => $row_data['city'],
                'country' => $row_data['country'],
                'size' => $row_data['size'],
                'price' => $row_data['price'],
                'allowed_animals' => $row_data['allowed_animals'],
                'num_beds' => $row_data['num_beds'],
            ];
            $estate = new Estate($data_estate);
            $favorite->estate = $estate;
            $result_array[] = $favorite;
        }

        return $result_array;
    }
}
