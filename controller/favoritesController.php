<?php

require_once( 'model/media.php' );

function favoritesPage() {
    $user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

    $favorites = Media::getAllFavorites($user_id);

    if (isset($_POST['deleteAllFavorites']))
    {
        Media::deleteAllFavorites($user_id);
        header('Location: '.$_SERVER['REQUEST_URI']); // Refresh once history has been wiped.
    }
    elseif (isset($_POST['deleteOneFavorite'])){
        Media::addMediaToFavorites($user_id, $_POST['deleteOneFavorite']);
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    require_once('view/favoritesView.php');
}