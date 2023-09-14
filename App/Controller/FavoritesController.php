<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Repository\AppRepoManager;
use Core\Session\Session;
use Core\View\View;
use Laminas\Diactoros\ServerRequest;


class FavoritesController extends Controller
{
    public function addEstateToFavorites(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $user_id = Session::get(Session::USER)->id;
        $data = [
            'user_id' => $user_id,
            'estate_id' => $post_data['estate_id'],
        ];
        AppRepoManager::getRm()->getFavoritesRepo()->insertEstateToFavorites($data);
    }

    public function deleteFavoriteByUser(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $user_id = Session::get(Session::USER)->id;
        $estate_id = $post_data['estate_id'];

        AppRepoManager::getRm()->getFavoritesRepo()->deleteFavorite($user_id, $estate_id);
    }

    public function seeAllFavoritesByUser(int $id)
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Home page',
            'favorites' => AppRepoManager::getRm()->getFavoritesRepo()->findFavoriteByUserIdWithModels($id),
        ];
        $view = new View('page/wishlist');
        $view->render($view_data);
    }
}
