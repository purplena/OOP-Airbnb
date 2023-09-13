<?php

namespace App\Model\Repository;

use App\Model\Estate;
use App\Model\PhotoEstate;
use App\Model\Reservation;
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

    public function findEstateById(int $id): Estate
    {
        $estate = $this->readById(Estate::class, $id);
        //Here I add to my models respective pictures of the estate by estate_id
        $estate->photos = AppRepoManager::getRm()->getPhotoEstateRepo()->findAllPhotosByEstateId($id);
        //Here I hydrate model Userby estate_id
        $estate->user = AppRepoManager::getRm()->getUserRepo()->findUserById($estate->user_id);
        //Here I hydrate model TypeEstate by estate_id
        $estate->typeEstate = AppRepoManager::getRm()->getTypeEstateRepo()->findTypeEstateById($estate->type_estate_id);
        //Here I hydrate model EstateEquipment and store all the equipment in the custom ptoperty of the model Estate that I cretaed myself equipment[]
        $estate->equiment = AppRepoManager::getRm()->getEstateEquipmentRepo()->findEquipmentByEstateId($estate->id);

        return $estate;
    }

    public function findAllEstatesByUserId(int $id)
    {
        $query = sprintf(
            '
            SELECT `%1$s`.*
            FROM `%s`
            WHERE `%1$s`.user_id = :id',
            $this->getTableName()
        );

        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute(['id' => $id]);
        $result = [];
        while ($row_data = $stmt->fetch()) {
            // var_dump($row_data);
            $estate = new Estate($row_data);
            $reservations = AppRepoManager::getRm()->getReservationRepo()->findReservationByEstateId($row_data['id']);
            $estate->reservations = $reservations;
            $estate->photos = AppRepoManager::getRm()->getPhotoEstateRepo()->findAllPhotosByEstateId($row_data['id']);
            $estate->equiment = AppRepoManager::getRm()->getEstateEquipmentRepo()->findEquipmentByEstateId($row_data['id']);
            $result[] = $estate;
        }

        return $result;
    }
}
