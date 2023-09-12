<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Core\Session\Session;
use Core\View\View;

class EstateController extends Controller
{
    public function detailsEstate(int $id)
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Check this place',
            'estate' => AppRepoManager::getRm()->getEstateRepo()->findEstateById($id),
            'form_result' => Session::get(Session::FORM_RESULT),
        ];

        $view = new View('page/estate_details');
        $view->render($view_data);
    }

    public function estatesByUser(int $id)
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Check this place',
            'estates' => AppRepoManager::getRm()->getEstateRepo()->findAllEstatesByUserId($id),
            'form_result' => Session::get(Session::FORM_RESULT),
        ];

        $view = new View('page/all_estates_by_user');
        $view->render($view_data);
    }
}
