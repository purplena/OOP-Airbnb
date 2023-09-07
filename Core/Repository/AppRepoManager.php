<?php

namespace Core\Repository;

use App\Model\Repository\UserRepository;
use Core\App;


class AppRepoManager
{
    //on import le trait
    use RepositoryManagerTrait;

    private UserRepository $userRepository;

    //on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->userRepository = new UserRepository($config);
    }

    public function getUserRepo(): UserRepository
    {
        return $this->userRepository;
    }
}
