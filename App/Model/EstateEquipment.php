<?php

namespace App\Model;

use App\Model\Equipment;
use App\Model\Estate;
use Core\Model\Model;

class EstateEquipment extends Model
{
    public int $estate_id;
    public int $equipment_id;
    public ?Estate $estate = null;
    public ?Equipment $equipment = null;
}
