<?php

namespace Core\Repository;

use App\Model\Repository\EquipmentRepository;
use App\Model\Repository\EstateEquipmentRepository;
use App\Model\Repository\EstateRepository;
use App\Model\Repository\PhotoEstateRepository;
use App\Model\Repository\ReservationRepository;
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
    private PhotoEstateRepository $photoEstate;
    private EstateEquipmentRepository $estateEquipment;
    private EstateRepository $estate;
    private ReservationRepository $reservation;

    //on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->userRepository = new UserRepository($config);
        $this->typeEstate = new TypeEstateRepository($config);
        $this->equipment = new EquipmentRepository($config);
        $this->photoEstate = new PhotoEstateRepository($config);
        $this->estateEquipment = new EstateEquipmentRepository($config);
        $this->estate = new EstateRepository($config);
        $this->reservation = new ReservationRepository($config);
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

    public function getPhotoEstateRepo(): PhotoEstateRepository
    {
        return $this->photoEstate;
    }

    public function getEstateEquipmentRepo(): EstateEquipmentRepository
    {
        return $this->estateEquipment;
    }

    public function getEstateRepo(): EstateRepository
    {
        return $this->estate;
    }

    public function getReservationRepo(): ReservationRepository
    {
        return $this->reservation;
    }
}
