<?php

namespace App\Model;


use App\Model\Estate;
use App\Model\User;
use Core\Model\Model;

class Favorites extends Model
{
    public int $user_id;
    public int $estate_id;
    public ?User $user = null;
    public ?Estate $estate = null;
}
