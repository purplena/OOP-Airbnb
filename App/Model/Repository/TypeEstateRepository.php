<?php

namespace App\Model\Repository;

use App\Model\TypeEstate;
use Core\Repository\Repository;

class TypeEstateRepository extends Repository
{
    public function getTableName(): string
    {
        return 'type_estate';
    }

    public function findAllTypesEstate(): array
    {
        return $this->readAll(TypeEstate::class);
    }
}
