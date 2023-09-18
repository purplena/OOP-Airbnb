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
    public function manageFavoritesByUser(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $user_id = Session::get(Session::USER)->id;
        $action = $post_data['action'];
        $estate_id = $post_data['estate_id'];
        $data = [
            'user_id' => $user_id,
            'estate_id' => $post_data['estate_id']
        ];

        if ($action == 'add') {
            AppRepoManager::getRm()->getFavoritesRepo()->insertEstateToFavorites($data);
        } else if ($action == 'delete') {
            AppRepoManager::getRm()->getFavoritesRepo()->deleteFavorite($user_id, $estate_id);
        }
    }

    public function seeAllFavoritesByUser(int $id)
    {
        $view_data = [
            'title_tag' => 'Airbnb',
            'h1_tag' => 'Check all your favorites',
            'favorites' => AppRepoManager::getRm()->getFavoritesRepo()->findFavoriteByUserIdWithModels($id),
        ];
        $view = new View('page/wishlist');
        $view->render($view_data);
    }

    public function deleteFromFavorites(int $id)
    {
        $user_id = Session::get(Session::USER)->id;
        AppRepoManager::getRm()->getFavoritesRepo()->deleteFavoriteByFavoriteId($id);
        self::redirect('/wishlist/' . $user_id);
    }
}
