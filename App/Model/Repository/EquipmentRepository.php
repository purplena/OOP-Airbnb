<?php

namespace App\Model\Repository;

use App\Model\Equipment;
use Core\Repository\Repository;

class EquipmentRepository extends Repository
{
    public function getTableName(): string
    {
        return 'equipment';
    }

    public function findAllEquipment(): array
    {
        return $this->readAll(Equipment::class);
    }
}
