<?php

namespace Core;

use App\Controller\JeuController;
use MiladRahimi\PhpRouter\Router;
use Core\Database\DatabaseConfigInterface;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Exceptions\InvalidCallableException;

class App implements DatabaseConfigInterface
{
    //on va déclarer des constantes pour la connexion à la base de données
    private const DB_HOST = 'database';
    private const DB_NAME = 'airbnb_database';
    private const DB_USER = 'admin';
    private const DB_PASS = 'admin';
    //on va créer une propriété qui va contenir l'instance de notre classe
    private static ?self $instance = null;
    //propriétét qui contient l'instance de Router (MiladRahimi)
    private Router $router;


    //création d'une méthode qui sera appelé au démarrage de l'appli dans index.php
    public static function getApp(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    //méthode qui instancie Router
    public function getRouter(): Router
    {
        return $this->router;
    }

    //when we instatiate class App, we instantiate at the same time Router
    //créer une instance de router
    private function __construct()
    {
        //on enregistre la route
        $this->router = Router::create();
    }

    //une fois le Router instancié, on aura 3 methode à definir
    //1: méthode start (activation du router)
    public function start(): void
    {
        //on démarre la session
        session_start();
        //on enregistre les routes 
        $this->registerRoutes();
        //on demarre le router
        $this->startRouter();
    }

    //2: méthode registerRoutes (enregistrer des routes)
    private function registerRoutes(): void
    {
        //on crée la route pour la page d'accueil 
        // $this->router->get('/', function() {
        //     echo "Utiliser le controlleur pour envoyer la vue";
        // });

        //déclaration des patterns pour tester les valeurs des arguments
        $this->router->pattern('id', '[0-9]\d*');
        $this->router->pattern('slug', '(\d+-)?[a-z]+(-[a-z-\d]+)*');

        //on crée la route pour la page d'accueil 
        $this->router->get('/', function () {
            echo "hello world";
        });
        $this->router->get('/jeu/{id}', [JeuController::class, 'detail']);
    }

    //3: methode startRouter (démarrage du router)
    public function startRouter(): void
    {
        try {
            $this->router->dispatch();
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        } catch (InvalidCallableException $e) {
            echo $e->getMessage();
        }
    }


    //on doir OBLIGATOIREMENT déclarer les methodes issus de l'interface
    public function getHost(): string
    {
        return self::DB_HOST;
    }

    public function getName(): string
    {
        return self::DB_NAME;
    }

    public function getUser(): string
    {
        return self::DB_USER;
    }

    public function getPass(): string
    {
        return self::DB_PASS;
    }
}
