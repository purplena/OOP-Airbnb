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

class ReservationController extends Controller
{
    public function addNewReservationPost(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        $date_start = DateTime::createFromFormat('d/m/Y', $post_data['date_start'])->format('Y-m-d');
        $date_finish = DateTime::createFromFormat('d/m/Y', $post_data['date_finish'])->format('Y-m-d');
        //Here I check the reservations according to the dates
        $reservatons = AppRepoManager::getRm()->getReservationRepo()->checkReservation($date_start, $date_finish, $post_data['estate_id']);

        //Validation to check that all fields are filled
        if (
            empty($post_data['estate_id']) ||
            empty($post_data['date_start']) ||
            empty($post_data['date_finish']) ||
            empty($post_data['num_guests'])
        ) {
            $form_result->addError(new FormError('Please fill in all the data'));
        } else if (!(Session::get(Session::USER))) {
            $form_result->addError(new FormError('Please log in first!'));
        } else if ($date_finish <= $date_start) {
            $form_result->addError(new FormError('Oops! Your dates are not correct'));
        } else if ($reservatons) {
            //Validation to check if there is already another trip  
            $form_result->addError(new FormError('Check other dates! Sorry...'));
        } else {
            $estate_id = intval($post_data['estate_id']);
            $user_id = intval(Session::get(Session::USER)->id);
            $num_guests = intval($post_data['num_guests']);
            if (empty($post_data['are_animals'])) {
                $are_animals = 0;
            } else {
                $are_animals = $post_data['are_animals'];
            }

            $data = [
                'user_id' => $user_id,
                'estate_id' => $estate_id,
                'date_start' => $date_start,
                'date_finish' => $date_finish,
                'num_guests' => $num_guests,
                'are_animals' => $are_animals
            ];
            // Here we make an insert into a table "estate"
            AppRepoManager::getRm()->getReservationRepo()->addNewReservation($data);
        }

        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/details/' . $post_data['estate_id']);
        }

        Session::remove(Session::FORM_RESULT);
        self::redirect('/trips/' . $user_id);
    }

    public function reservationsByUser(int $id)
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Check all your reservations',
            'reservations' => AppRepoManager::getRm()->getReservationRepo()->reservationsByUser($id),
        ];

        $view = new View('page/all_reservations_by_user');
        $view->render($view_data);
    }

    public function deleteReservation(int $id): void
    {
        AppRepoManager::getRm()->getReservationRepo()->deleteReservationById($id);
        self::redirect('/');
    }
}
