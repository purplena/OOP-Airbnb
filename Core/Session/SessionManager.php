<?php
namespace Core\Session;

class SessionManager 
{
    //méthode pour pouvoir alimenter notre session
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value; 
    }
    
    //méthode pour pouvoir récupérer notre session
    public static function get(string $key)
    {   
        if(!isset($_SESSION[$key])) return null;
        
        return $_SESSION[$key];
    }

    //méthode pour pouvoir vider notre session
    public static function remove(string $key): void
    {
        //si j'essaye de supprimer une session qui n'existe pas, je fais rien
        if(!self::get($key)) return;
        //sinon je supprime la session
        unset($_SESSION[$key]);
    }
}