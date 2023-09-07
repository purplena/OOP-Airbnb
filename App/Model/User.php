<?php

namespace App\Model;

use Core\Model\Model;

class User extends Model
{
    public string $first_name;
    public string $second_name;
    public string $email;
    public string $password;
    public string $photo_user;
}
