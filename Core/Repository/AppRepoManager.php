<?php

namespace Core\Repository;

use Core\App;
use App\Model\Repository\ConsoleRepository;
use App\Model\Repository\GameConsoleRepository;
use App\Model\Repository\JeuRepository;
use App\Model\Repository\NoteRepository;
use App\Model\Repository\RestrictionAgeRepository;

class AppRepoManager
{
    //on import le trait
    use RepositoryManagerTrait;

    private JeuRepository $jeuRepository; 
    private NoteRepository $noteRepository; 
    private RestrictionAgeRepository $restrictionAge;
    private GameConsoleRepository $gameConsole;
    private ConsoleRepository $console;


    //on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->jeuRepository = new JeuRepository($config);
        $this->noteRepository = new NoteRepository($config);
        $this->restrictionAge = new RestrictionAgeRepository($config);
        $this->gameConsole = new GameConsoleRepository($config);
        $this->console = new ConsoleRepository($config);
    }

    public function getJeuRepo(): JeuRepository
    {
        return $this->jeuRepository;
    }

    public function getNoteRepo(): NoteRepository
    {
        return $this->noteRepository;
    }

    public function getRestrictionAgeRepo(): RestrictionAgeRepository
    {
        return $this->restrictionAge;
    }

    public function getGameConsoleRepo(): GameConsoleRepository
    {
        return $this->gameConsole;
    }

    public function getConsoleRepo(): ConsoleRepository
    {
        return $this->console;
    }
}