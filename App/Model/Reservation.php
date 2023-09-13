<?php

namespace App\Model;

use App\Model\Estate;
use App\Model\User;
use Core\Model\Model;

class Reservation extends Model
{
    public int $user_id;
    public int $estate_id;
    public string $date_start;
    public string $date_finish;
    public int $num_guests;
    public int $are_animals;
    public array $host;
    // public array $equiment;


    public ?User $user = null;
    public ?Estate $estate = null;
}
