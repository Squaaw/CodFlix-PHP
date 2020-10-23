<?php

session_start();

require_once( 'model/user.php' );

/****************************
* ----- LOAD LOGIN PAGE -----
****************************/

function loginPage() {

  $user     = new stdClass();
  $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( !$user->id ):
    require('view/auth/loginView.php');
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- LOGIN FUNCTION -----
***************************/

function login( $post ) {

  $data           = new stdClass();
  $data->email    = $post['email'];
  $data->password = hash('sha256', $post['password']); // Hash password input to get a match with current registered password into DB.

  $user = null;
  $userData = null;

  // Prevent exception to show up if mail doesn't match with the correct regex.
  if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $post['email']))
  {
    $user           = new User( $data );
    $userData       = $user->getUserByEmail();
  }

  $error_msg      = "Email ou mot de passe incorrect";

  if( $userData && sizeof( $userData ) != 0 ) // If the user exists.
  {
    if( $user->getPassword() == $userData['password'] ) // If the input password matches with the password in DB.
    {
      // THE CODE BELOW WILL BE ACTIVATED ONCE THE MAIL CAN BE SENT!!!
      // if($userData['active'] != 'N') // If user's account is activated.
      // {
        // Set session
        $_SESSION['user_id'] = $userData['id'];

        header( 'location: index.php ');
      // }
      // else // If the user has not activated his account, yet.
      // {
        $error_msg = "Votre compte n'est pas activé. Veuillez cliquer sur le lien envoyé par mail lors de votre inscription.";
      // }  
    }
  }

  require('view/auth/loginView.php');
}

/****************************
* ----- LOGOUT FUNCTION -----
****************************/

function logout() {
  $_SESSION = array();
  session_destroy();

  header( 'location: index.php' );
}
