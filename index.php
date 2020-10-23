<?php

require_once( 'controller/homeController.php' );
require_once( 'controller/loginController.php' );
require_once( 'controller/signupController.php' );
require_once( 'controller/mediaController.php' );
require_once( 'controller/tokenController.php' );
require_once( 'controller/contactController.php' );
require_once( 'controller/accountController.php' );
require_once( 'controller/historyController.php' );
require_once( 'controller/favoritesController.php' );

/**************************
* ----- HANDLE ACTION -----
***************************/

$user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

if ( isset( $_GET['action'] ) ):

  // Wether the user is logged in or not, redirect to contact form.
  if ( $_GET['action'] == 'contact' ):
    if ( !empty( $_POST )) contact($_POST);
    else require('view/contactView.php');

  // Redirect to login or sign up form ONLY if no user is logged on. Default: redirect to main homepage.
  elseif (!$user_id):
    switch( $_GET['action']):

      case 'login':
        if ( !empty( $_POST ) ) login( $_POST );
        else loginPage();
      break;

      case 'signup':
        if ( !empty( $_POST ) ) signUp($_POST);
        else signupPage();
      break;

      default:
        homePage();        
    endswitch;

  // Logout or redirect to profile page ONLY if the user is logged on. Default: redirect to mediapage.
  else:
    switch ( $_GET['action'] ):

      case 'logout':
        logout();
      break;

      case 'account':
        if ( !empty ($_POST) && isset($_POST['deleteAccount'])){
          deleteAccount($_POST);
        }
        elseif (!empty ($_POST) && ( isset( $_POST['changePassword'] ) || isset( $_POST['changeMail'] ) )){
          updateAccount($_POST);
        }
        else{
          accountPage();
        }       
      break;

      case 'history':
        mediaHistory();
      break;

      case 'favorites':
        favoritesPage();
      break;

      default:
        mediaPage();
    endswitch;
  endif;

// Redirect to token page ONLY if no user is logged on and the query string ?token= is present.
elseif ( isset( $_GET['token'] ) && !$user_id ):
  tokenPage();

// If there is no query string, redirect to mediapage or homepage wether the user is logged or not.
else:
  if( $user_id ):
    mediaPage();
  else:
    homePage();
  endif;
endif;