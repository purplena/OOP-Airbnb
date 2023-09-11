<?php

namespace App\Model\Repository;

use App\Model\Estate;
use App\Model\PhotoEstate;
use Core\Repository\AppRepoManager;
use Core\Repository\Repository;

class PhotoEstateRepository extends Repository
{
    public function getTableName(): string
    {
        return 'photo_estate';
    }

    public function insertPhotoEstateRow(array $data): bool
    {
        $query = sprintf(
            '
            INSERT INTO `%s`
            (`estate_id`, `photo_estate_path`) 
            VALUES 
            (:estate_id, :photo_estate_path)',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return false;
        $stmt->execute($data);

        return true;
    }

    public function findAllPhotosByEstateId(int $estate_id): ?array
    {
        $query = sprintf(
            '
            SELECT *  
            FROM `%s`
            WHERE estate_id = :estate_id
            ',
            $this->getTableName()
        );

        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute(['estate_id' => $estate_id]);
        $result = [];
        while ($row_data = $stmt->fetch()) {
            $result[] = $row_data['photo_estate_path'];
        }

        return $result;
    }
}
