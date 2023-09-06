<?php
namespace Core\Database;

use PDO;
use Core\Database\DatabaseConfigInterface;

//Design Pattern Singleton (ne peut être instanciée qu'une seule fois)
//It means that once we have a connection to our database, we do not need to instantiate this class anymore
class Database
{
    private static ?PDO $pdoInstance = null; 

    private const PDO_OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    public static function getPDO(DatabaseConfigInterface $config): PDO 
    {
        if(is_null(self::$pdoInstance)) {
            $dsn = sprintf('mysql:dbname=%s;host=%s', $config->getName(), $config->getHost());
            self::$pdoInstance = new PDO($dsn, $config->getUser(), $config->getPass(), self::PDO_OPTIONS);
        }

        return self::$pdoInstance;
    }

    //on declare le constructeur en private pour bloquer l'instancion de la classe
    private function __construct() {}

    //on declare la methode clone en pivate pour bloquer la clonage de la classe
    private function __clone() {}

    //on declare la methode wakeup en private pour bloquer la deserialisation de la classe
    public function __wakeup() {}

}