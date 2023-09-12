<?php

namespace App\Model\Repository;


use Core\Repository\AppRepoManager;
use Core\Repository\Repository;

class EstateEquipmentRepository extends Repository
{
    public function getTableName(): string
    {
        return 'estate_equipment';
    }

    public function insertEstateEquipmentRow(array $data): bool
    {
        $query = sprintf(
            '
            INSERT INTO `%s`
            (`estate_id`, `equipment_id`) 
            VALUES 
            (:estate_id, :equipment_id)',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return false;
        $stmt->execute($data);

        return true;
    }

    public function findEquipmentByEstateId(int $id)
    {
        $query = sprintf(
            '
            SELECT `%1$s`.estate_id, `%1$s`.equipment_id, `%2$s`.label_equipment, `%2$s`.type_equipment
            FROM `%1$s`
            INNER JOIN `%2$s` 
            ON `%1$s`.equipment_id = `%2$s`.id
            WHERE `%1$s`.estate_id = :id',
            $this->getTableName(),
            AppRepoManager::getRm()->getEquipmentRepo()->getTableName()
        );

        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute(['id' => $id]);
        $arr_result = [];
        while ($row_data = $stmt->fetch()) {
            $arr_result[] = $row_data;
        }

        $regroupedArray = [];
        foreach ($arr_result as $equipment) {
            $equipmentType = $equipment['type_equipment'];
            if (!isset($regroupedArray[$equipmentType])) {
                $regroupedArray[$equipmentType] = [];
            }
            $regroupedArray[$equipmentType][] = [
                "equipment_id" => $equipment['equipment_id'],
                "label_equipment" => $equipment['label_equipment']
            ];
        }


        return $regroupedArray;
    }
}
