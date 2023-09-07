<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Session\Session;
use Core\View\View;

class PageController extends Controller
{
    public function index()
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Home page',


        ];
        $view = new View('page/home');
        $view->render($view_data);
    }
}
