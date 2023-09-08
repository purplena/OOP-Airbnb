<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Form\FormResult;
use Core\View\View;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\UploadedFile;

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

    public function addNewEstateView()
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Add new Estate',


        ];
        $view = new View('page/add_new_estate');
        $view->render($view_data);
    }

    public function addNewEstatePost(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        // $image_data = $_FILES['image'];
        $form_result = new FormResult();

        var_dump($_FILES['files']);
        die;
        $response = "";
        if (isset($_FILES['files'])) {
            if ($_FILES['file']['name'][0] == "") {
            }
        }
    }
}
