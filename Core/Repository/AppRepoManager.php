<?php

namespace Core\Repository;

use App\Model\Repository\EquipmentRepository;
use App\Model\Repository\TypeEstateRepository;
use App\Model\Repository\UserRepository;
use Core\App;


class AppRepoManager
{
    //on import le trait
    use RepositoryManagerTrait;

    private UserRepository $userRepository;
    private TypeEstateRepository $typeEstate;
    private EquipmentRepository $equipment;

    //on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->userRepository = new UserRepository($config);
        $this->typeEstate = new TypeEstateRepository($config);
        $this->equipment = new EquipmentRepository($config);
    }

    public function getUserRepo(): UserRepository
    {
        return $this->userRepository;
    }

    public function getTypeEstateRepo(): TypeEstateRepository
    {
        return $this->typeEstate;
    }

    public function getEquipmentRepo(): EquipmentRepository
    {
        return $this->equipment;
    }
}
