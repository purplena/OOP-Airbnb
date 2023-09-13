<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Repository\AppRepoManager;
use Core\Session\Session;
use Core\View\View;
use DateTime;
use Laminas\Diactoros\ServerRequest;

class EstateController extends Controller
{
    public function detailsEstate(int $id)
    {
        $reservations = AppRepoManager::getRm()->getReservationRepo()->findReservationByEstateId($id);
        $reservation_dates_by_estate_id = [];
        foreach ($reservations as $reservation) {
            $reservation_dates_by_estate_id[] = [$reservation->date_start, $reservation->date_finish];
        }
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Check this place',
            'estate' => AppRepoManager::getRm()->getEstateRepo()->findEstateById($id),
            'reservations' => $reservation_dates_by_estate_id,
            'form_result' => Session::get(Session::FORM_RESULT),
        ];

        $view = new View('page/estate_details');
        $view->render($view_data);
    }

    public function estatesByUser(int $id)
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Check all your Airbnbs',
            'estates' => AppRepoManager::getRm()->getEstateRepo()->findAllEstatesByUserId($id),
        ];

        $view = new View('page/all_estates_by_user');
        $view->render($view_data);
    }
}
