<?php

use Core\App;
require '../vendor/autoload.php';

const DS = DIRECTORY_SEPARATOR; 
//here we are in the root of our project
define('PATH_ROOT', dirname(__DIR__) . DS);

App::getApp()->start();