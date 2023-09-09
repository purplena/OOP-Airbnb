<?php

namespace App\Model;

use App\Model\Equipment;
use App\Model\Estate;
use Core\Model\Model;

class PhotoEstate extends Model
{
    public int $estate_id;
    public string $photo_estate_path;
    public ?Estate $estate = null;
}
