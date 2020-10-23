<?php

require_once( 'model/media.php' );

function mediaHistory() {
    $user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

    $visitedMedias = Media::getVisitedMedias($user_id);

    if (isset($_POST['deleteAllHistory']))
    {
        Media::deleteAllHistory($user_id);
        header('Location: '.$_SERVER['REQUEST_URI']); // Refresh once history has been wiped.
    }
    elseif (isset($_POST['deleteOneMedia'])){
        Media::deleteOneMedia($user_id, $_POST['deleteOneMedia']);
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    require_once('view/historyView.php');
}