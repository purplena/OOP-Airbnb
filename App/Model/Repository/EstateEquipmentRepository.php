<?php

namespace App\Model\Repository;


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
}
