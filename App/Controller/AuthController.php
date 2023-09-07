<?php

namespace App\Controller;

use App\Model\User;
use Core\Controller\Controller;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Repository\AppRepoManager;
use Core\Session\Session;
use Core\View\View;
use Laminas\Diactoros\ServerRequest;

class AuthController extends Controller
{

    public const AUTH_SALT = 'c56a7523d96942a834b9cdc249bd4e8c7aa9';
    public const AUTH_PEPPER = '8d746680fd4d7cbac57fa9f033115fc52196';

    public function login()
    {
        $view = new View('auth/login', false);
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Welcome back',
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view->render($view_data);
    }

    public function signup()
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Welcome to Airbnb',
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view = new View('auth/signup', false);
        $view->render($view_data);
    }




    public function loginPost(ServerRequest $request)
    {
        //on récupere les données du formulaire dans une variable
        $post_data = $request->getParsedBody();
        //on va créer une instance de FormResult
        $form_result = new FormResult();

        //on crée une instance de users
        $user = new User();

        //on vérifie que les champs sont remplis
        if (empty($post_data['email'] || $post_data['password'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
        } else {
            //sinon on confronte les valeurs saisie aven les données en BDD
            // on redefinit des variable
            $email = $post_data['email'];
            $password = self::hash($post_data['password']);

            //appel du repository pour vérifier que l'utilisateur existe
            $user = AppRepoManager::getRm()->getUserRepo()->checkAuth($email, $password);
            //si retour négatif, on affiche un message d'erreur
            if (is_null($user)) {
                $form_result->addError(new FormError('Email ou mot de pass incorrect'));
            }
        }

        //si il y a des erreurs, on renvoie vers la pagge connexion
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/login');
        }

        //si tout s'est bien passé, on enregistre l'utilisateur en session et on redirige vers la page d'assueil
        //on efface le mot de pass
        $user->password = "";
        Session::set(Session::USER, $user);
        //puis on redirige
        self::redirect('/');
    }

    public function signUpPost(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $image_data = $_FILES['image'];
        $form_result = new FormResult();

        if (
            $image_data['type'] !== 'image/jpeg' &&
            $image_data['type'] !== 'image/png' &&
            $image_data['type'] !== 'image/jpg' &&
            $image_data['type'] !== 'image/webp'
        ) {
            $form_result->addError(new FormError('The image format is not valid'));
        } else if (
            empty($post_data['first_name']) ||
            empty($post_data['second_name']) ||
            empty($post_data['email']) ||
            empty($post_data['password'])
        ) {
            $form_result->addError(new FormError('Please fill in all the information'));
        } else if (!filter_var($post_data['email'], FILTER_VALIDATE_EMAIL)) {
            $form_result->addError(new FormError('Your email is not valid'));
        } else {
            $first_name = htmlspecialchars((trim($post_data['first_name'])));
            $second_name = htmlspecialchars((trim($post_data['second_name'])));
            $email = trim($post_data['email']);
            $password = trim(self::hash($post_data['password']));
            $imgTmpPath = $image_data['tmp_name'];
            $filename = uniqid() . '_' . $image_data['name'];
            $imgPathPublic = PATH_ROOT . '/public/images/' . $filename;
            $data = [
                'first_name' => $first_name,
                'second_name' => $second_name,
                'email' => $email,
                'password' => $password,
                'photo_user' => $filename,
            ];

            if (move_uploaded_file($imgTmpPath, $imgPathPublic)) {
                $user = AppRepoManager::getRm()->getUserRepo()->addNewUser($data);
            } else {
                $form_result->addError(new FormError('Error! Try again later!'));
            }
        }

        if ($form_result->hasError()) {
            //if errors _ back to signup page
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/signup');
        }

        //no errors _ back to home page
        Session::set(Session::USER, $user);
        Session::remove(Session::FORM_RESULT);
        self::redirect('/');
    }

    public static function hash(string $password): string
    {
        return hash('sha512', self::AUTH_SALT . $password . self::AUTH_PEPPER);
    }

    public static function isAuth(): bool
    {
        return !is_null(Session::get(Session::USER));
    }

    public function logout()
    {
        //on detruit la session
        Session::remove(Session::USER);
        self::redirect('/');
    }
}
