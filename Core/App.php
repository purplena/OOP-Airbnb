<?php

namespace Core;


use App\Controller\AuthController;
use App\Controller\EstateController;
use App\Controller\FavoritesController;
use App\Controller\PageController;
use App\Controller\ReservationController;
use Core\Database\DatabaseConfigInterface;
use MiladRahimi\PhpRouter\Exceptions\InvalidCallableException;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Router;

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
        //déclaration des patterns pour tester les valeurs des arguments
        $this->router->pattern('id', '[0-9]\d*');
        $this->router->pattern('slug', '(\d+-)?[a-z]+(-[a-z-\d]+)*');

        //Home Page 
        $this->router->get('/', [PageController::class, 'index']);
        //SignUp
        $this->router->get('/signup', [AuthController::class, 'signup']);
        $this->router->post('/signUpPost', [AuthController::class, 'signUpPost']);
        //Sign in
        $this->router->get('/login', [AuthController::class, 'login']);
        $this->router->post('/loginPost', [AuthController::class, 'loginPost']);
        //log out
        $this->router->get('/logout', [AuthController::class, 'logout']);
        //Page to add a new appartment
        $this->router->get('/airbnb-your-home', [PageController::class, 'addNewEstateView']);
        $this->router->post('/addNewEstatePost', [PageController::class, 'addNewEstatePost']);
        //details of estate
        $this->router->get('/details/{id}', [EstateController::class, 'detailsEstate']);
        //Route to make reservation
        $this->router->post('/reservationPost', [ReservationController::class, 'addNewReservationPost']);
        //to see all estates that this user has 
        $this->router->get('/myAirbnbs/{id}', [EstateController::class, 'estatesByUser']);
        //route to see all reservations
        $this->router->get('/trips/{id}', [ReservationController::class, 'reservationsByUser']);
        //route to delete a reservation
        $this->router->get('/trips/deleteReservation/{id}', [ReservationController::class, 'deleteReservation']);
        //route to manage favorites (toggle) 
        $this->router->post('/manageFavoritesByUser', [FavoritesController::class, 'manageFavoritesByUser']);
        //route to see wishlist
        $this->router->get('/wishlist/{id}', [FavoritesController::class, 'seeAllFavoritesByUser']);
        //route to delete from wishlist
        $this->router->get('/wishlist/deleteFromFavorites/{id}', [FavoritesController::class, 'deleteFromFavorites']);
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
