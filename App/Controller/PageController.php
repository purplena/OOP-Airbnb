<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Repository\AppRepoManager;
use Core\Session\Session;
use Core\View\View;
use Laminas\Diactoros\ServerRequest;

class PageController extends Controller
{
    public function index()
    {
        if (Session::get(Session::USER)) {
            $favorites = AppRepoManager::getRm()->getFavoritesRepo()->findFavoriteByUserId(Session::get(Session::USER)->id);
        } else {
            $favorites = null;
        }

        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Home page',
            'estates' => AppRepoManager::getRm()->getEstateRepo()->findAllEstates(),
            'favorites' => $favorites
        ];
        $view = new View('page/home');
        $view->render($view_data);
    }

    public function addNewEstateView()
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Add new Estate',
            'types_estate' => AppRepoManager::getRm()->getTypeEstateRepo()->findAllTypesEstate(),
            'form_result' => Session::get(Session::FORM_RESULT),
            'allEquipment' => AppRepoManager::getRm()->getEquipmentRepo()->findAllEquipment(),
        ];
        $view = new View('page/add_new_estate');
        $view->render($view_data);
    }

    public function addNewEstatePost(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $image_data = $_FILES['files'];
        $form_result = new FormResult();

        //Block of Validation to check if there is an error in the image format
        foreach ($image_data['type'] as $key => $value) {
            if (
                $value !== 'image/jpeg' &&
                $value !== 'image/png' &&
                $value !== 'image/jpg' &&
                $value !== 'image/webp'
            ) {
                $form_result->addError(new FormError('Please insert an image (jpeg/png/jpg/webp)'));
            }
        }

        //Block of Validation to check if all the fields have been filled in
        if (
            empty($post_data['type_estate_id']) ||
            empty($post_data['country']) ||
            empty($post_data['city']) ||
            empty($post_data['price']) ||
            empty($post_data['size']) ||
            empty($post_data['num_rooms']) ||
            empty($post_data['num_beds']) ||
            empty($post_data['allowed_animals']) ||
            empty($post_data['description'])
        ) {
            $form_result->addError(new FormError('Please fill in all the data'));
        }

        //Block of Validation to check if there are more that two digits after coma in price
        if (self::checkIfHasMoreThanTwoDegits($post_data['price'])) {
            $form_result->addError(new FormError('We accept the following format: 20.99!'));
        }

        //Block of Validation to check if size, number of romms and beds is the whole number
        if (self::checkIfDecimalNumber($post_data['size']) || self::checkIfDecimalNumber($post_data['num_rooms']) || self::checkIfDecimalNumber($post_data['num_beds'])) {
            $form_result->addError(new FormError('Please fill the whole number!'));
        }

        $user_id = intval($post_data['user_id']);
        $type_estate_id = intval($post_data['type_estate_id']);
        $country = htmlspecialchars((trim($post_data['country'])));
        $city = htmlspecialchars((trim($post_data['city'])));
        $price = intval($post_data['price']);
        $size = intval($post_data['size']);
        $num_rooms = intval($post_data['num_rooms']);
        $num_beds = intval($post_data['num_beds']);
        $allowed_animals = intval($post_data['allowed_animals']);
        $description = htmlspecialchars((trim($post_data['description'])));

        $data = [
            'user_id' => $user_id,
            'type_estate_id' => $type_estate_id,
            'country' => $country,
            'city' => $city,
            'price' => $price,
            'size' => $size,
            'num_rooms' => $num_rooms,
            'num_beds' => $num_beds,
            'allowed_animals' => $allowed_animals,
            'description' => $description
        ];
        // Here we make an insert into a table "estate"
        AppRepoManager::getRm()->getEstateRepo()->insertEstate($data);

        // Here we get the current id of the estate to continue insert
        $estate_id = AppRepoManager::getRm()->getEstateRepo()->findMaxEstateId();

        //Here we make an insert of the equipment in the table equipment_estate
        //using the current id of the estate
        foreach ($post_data['equipment_id'] as $key => $value) {
            $data = [
                'estate_id' => $estate_id,
                'equipment_id' => intval($value)
            ];

            AppRepoManager::getRm()->getEstateEquipmentRepo()->insertEstateEquipmentRow($data);
        }

        $imageTmpPaths = [];
        foreach ($image_data['tmp_name'] as $key => $value) {
            $imageTmpPaths[] = $value;
        }
        $fileNames = [];
        foreach ($image_data['name'] as $key => $value) {
            $fileNames[] = uniqid() . '_' . $value;
        }

        // Here I reconstruct my two arrays into $key=>$value pairs
        //Example
        // array (size=2)
        // '/tmp/phpvZ87Iz' => string '64fed393acec0_image1.jpg' (length=24)
        // '/tmp/phpO7yhJz' => string '64fed393acec5_image2.jpg' (length=24)

        $results = [];
        for ($i = 0; $i < count($imageTmpPaths); $i++) {
            $results[$imageTmpPaths[$i]] = $fileNames[$i];
        }

        //Now I can sipmly itterate and make at the same time two operations
        //1 to insert into a database
        //2 to relocate temp file on my webserver
        foreach ($results as $key => $value) {
            $data = [
                'estate_id' => $estate_id,
                'photo_estate_path' => $value
            ];
            AppRepoManager::getRm()->getPhotoEstateRepo()->insertPhotoEstateRow($data);
            $imgPathPublic = PATH_ROOT . '/public/images/estate_img/' . $value;
            move_uploaded_file($key, $imgPathPublic);
        }


        // Here we stock our errors and redirect back
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/airbnb-your-home');
        }

        Session::remove(Session::FORM_RESULT);
        self::redirect('/');
    }

    public static function checkIfHasMoreThanTwoDegits(string $number): bool
    {
        $decimalPointPosition = strpos($number, '.');
        $digitsAfterDecimal = strlen($number) - $decimalPointPosition - 1;
        if ($digitsAfterDecimal > 2) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkIfDecimalNumber(string $number): bool
    {
        $decimalPointPosition = strpos($number, '.');

        if ($decimalPointPosition === false) {
            return false;
        } else {
            return true;
        }
    }
}
