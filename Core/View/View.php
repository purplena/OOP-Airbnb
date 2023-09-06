<?php 

namespace Core\View;

use App\Controller\AuthController;

class View 
{
    //on définit le chemin absolu vers le dossier contenant les vues
    //on peut réutiliser les constantes de index.php

    public const PATH_VIEW = PATH_ROOT . 'views' . DS;
    //on récupère le chemin de notre dossier _templates
    public const PATH_PARTIALS = self::PATH_VIEW . '_templates' .DS;
    //on déclare une propriété titre 
    public string $title = 'Titre par défaut';
    
    //on déclare notre constructeur
    public function __construct(
        private string $name,
        private bool $is_complete = true
    ) {}

    //on crée une méthode pour récuperer le chemin de la vue
    private function getRequirePath(): string
    {
        //Renderer :: home/index
        $arr_name = explode('/', $this->name);
        $category = $arr_name[0];
        $name = $arr_name[1];
        $name_prefix = $this->is_complete ? '' : '_';

        return self::PATH_VIEW . $category . DS . $name_prefix . $name . '.html.php';
    }

    //on crée notre méthode de rendu
    //we wait or for null or for an array
    public function render(?array $view_data = []): void
    {
        //on check si l'utilisateur est en session
        //sinon on redirige vars la page de connexion
        $auth = AuthController::class;

        if(!empty($view_data)) {
            extract($view_data);
        }

        //mise en cache de resultat
        ob_start();
        //on import le template __header
        if($this->is_complete) {
            require self::PATH_PARTIALS . '_header.html.php';
        }

        //on inclut le fichier de la vue
        require $this->getRequirePath();

        //on import le template footer
        if($this->is_complete) {
            require self::PATH_PARTIALS . '_footer.html.php';
        }
        //liberation du cache
        ob_end_flush();

    }
}