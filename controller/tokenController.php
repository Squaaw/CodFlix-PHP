<?php

require_once( 'model/token.php' );

/****************************
* ----- LOAD SIGNUP PAGE -----
****************************/

function tokenPage() {
    $token = $_GET['token'];
    $response = getTokenByToken($token);

    // Check if the token exists into the DB.
    if (!$response){
        $error_msg = "Une erreur est survenue.";
    }
    else{
        activateAccount($token); // Set user's status true (field active = 'O' instead of 'N'), then delete the token.
        $success_msg = "Votre compte est désormais activé.";
    }

    require('view/tokenView.php');
}