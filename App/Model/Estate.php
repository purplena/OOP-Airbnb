<?php

namespace App\Model;

use App\Model\User;
use Core\Model\Model;

class Estate extends Model
{
    public int $user_id;
    public int $type_estate_id;
    public int $price;
    public int $size;
    public int $num_rooms;
    public int $num_beds;
    public string $description;
    public string $city;
    public string $country;
    public int $allowed_animals;


    public ?User $user = null;
    public ?TypeEstate $typeEstate = null;
}
