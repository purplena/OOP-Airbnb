<?php

namespace App\Model\Repository;

use App\Model\Estate;
use App\Model\PhotoEstate;
use Core\Repository\AppRepoManager;
use Core\Repository\Repository;

class EstateRepository extends Repository
{
    public function getTableName(): string
    {
        return 'estate';
    }

    public function insertEstate(array $data): bool
    {
        $query = sprintf(
            '
            INSERT INTO `%s` 
            (`user_id`, `type_estate_id`, `price`, `size`, `num_rooms`, `num_beds`, `description`, `city`, `country`, `allowed_animals`) 
            VALUES 
            (:user_id, :type_estate_id, :price, :size, :num_rooms, :num_beds, :description, :city, :country, :allowed_animals)',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return false;
        $stmt->execute($data);

        return true;
    }

    public function findMaxEstateId(): ?int
    {
        $result = "";
        $query = sprintf(
            '
            SELECT MAX(Id) 
            FROM `%s`',
            $this->getTableName()
        );

        $stmt_brand = $this->pdo->query($query);

        if (!$stmt_brand) return null;
        $result = $stmt_brand->fetch()['MAX(Id)'];

        return $result;
    }

    public function findAllEstates(): ?array
    {

        $arr_result = [];
        $query = sprintf(
            '
            SELECT `%1$s`.*
            FROM `%s`',
            $this->getTableName()
        );

        $stmt = $this->pdo->query($query);
        if (!$stmt) return null;

        while ($row_data = $stmt->fetch()) {
            $estate = new Estate($row_data);
            $estate->photos = AppRepoManager::getRm()->getPhotoEstateRepo()->findAllPhotosByEstateId($row_data['id']);
            $arr_result[] = $estate;
        }

        return $arr_result;
    }
}
