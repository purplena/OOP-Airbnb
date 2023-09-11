<?php

namespace App\Model\Repository;

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
}
