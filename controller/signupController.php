<?php

require_once( 'model/user.php' );

/****************************
* ----- LOAD SIGNUP PAGE -----
****************************/

function signupPage() {

  $user     = new stdClass();
  $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( !$user->id ):
    require('view/auth/signupView.php');
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- SIGNUP FUNCTION -----
***************************/

function signUp( $post ) {

  $email = $post['email'];
  $password = $post['password'];
  $password_confirm = $post['password_confirm'];

  // If email input is empty or doesn't match the regex, show error.
  if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email))
  {
    $error_msg = "Format de mail non valide.";
  }
  else
  {
    $data           = new stdClass();
    $data->email    = $email;
    $data->password = $password;

    $user           = new User( $data );
    $userData       = $user->getUserByEmail();

    if ($userData && sizeof( $userData ) > 0) // If email address is already in used, show error.
    {
      $error_msg = "Cette adresse mail est déjà utilisée.";
    }
    elseif (strlen($password) < 6) // If password input length is less than 6 chars, show error.
    {
      $error_msg = "Mot de passe incorrect. Min. 6 caractères.";
    }
    elseif ($password != $password_confirm) // If both password don't match, show error.
    {
      $error_msg = "Les mots de passes ne correspondent pas.";
    }
    else
    {
      // Create new user.
      $password = hash('sha256', $password);
      $user = new User();
      $user->setEmail($email);
      $user->setPassword($password);
      $user->createUser();
      $success_msg = "Votre inscription s'est déroulée avec succès."; //Un mail d'activation vous a été envoyé.
    }
  }

  require('view/auth/signupView.php');
}