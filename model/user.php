<?php

require_once( 'database.php' );

class User {

  protected $id;
  protected $email;
  protected $password;

  public function __construct( $user = null ) {

    if( $user != null ):
      $this->setId( isset( $user->id ) ? $user->id : null );
      $this->setEmail( $user->email );
      $this->setPassword( $user->password, isset( $user->password_confirm ) ? $user->password_confirm : false );
    endif;
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setEmail( $email ) {

    if ( !filter_var($email, FILTER_VALIDATE_EMAIL)):
      throw new Exception( 'Email incorrect' );
    endif;

    $this->email = $email;

  }

  public function setPassword( $password, $password_confirm = false ) {

    if( $password_confirm && $password != $password_confirm ):
      throw new Exception( 'Vos mots de passes sont différents' );
    endif;

    $this->password = $password;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPassword() {
    return $this->password;
  }

  /***********************************
  * -------- CREATE NEW USER ---------
  ************************************/

  public function createUser() {

    // Open database connection
    $db   = init_db();

    // Check if email already exist
    $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
    $req->execute( array( $this->getEmail() ) );

    if( $req->rowCount() > 0 ) throw new Exception( "Email ou mot de passe incorrect" );

    // Insert new user
    $req->closeCursor();

    $req  = $db->prepare( "INSERT INTO user ( email, password, active ) VALUES ( :email, :password, :active )" );
    $req->execute( array(
      'email'     => $this->getEmail(),
      'password'  => $this->getPassword(),
      'active' => 'O' // Default value should be 'N' once it would be possible to send mail to users in order to activate their account.
    ));

    // Get user's data once inserted into DB.
    $getUser = $this->getUserByEmail();

    // Create a unique random token.
    $token = md5(microtime(TRUE)*100000);

    // Insert the token in order to allow the user to active the account.
    $req = $db->prepare( "INSERT INTO token (user_id, token ) VALUES (:userId, :token)" );
    $req->execute( array(
      'userId' => $getUser['id'],
      'token' => $token
    ));

    // Send validation mail with a custom url so that the user can activate his account.
    $this->sendValidationMail($token, $getUser['email']);

    // Close database connection
    $db = null;

  }

  function sendValidationMail($token, $userMail) {
    $userMail = $userMail;
    $subject = "Activation de votre compte Cod'Flix";
    $header = "L'équipe Cod'Flix";
    $message = 'Bienvenue sur Cod\'Flix !
    
    Afin d\'activer votre compte, veuillez cliquer sur le lien ci-dessous :

    http://localhost/ec-code-2020-codflix-php/index.php?token='.$token.'

    A très vite sur Cod\'Flix, votre plateforme n°1 du streaming.';

    //TODO: SET IN "sendmail_from" in php.ini in order to use mail().
    // mail($userMail, $subject, $message, $header);
}

  /**************************************
  * -------- GET USER DATA BY ID --------
  ***************************************/

  public static function getUserById( $id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE id = ?" );
    $req->execute( array( $id ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  /***************************************
  * ------- GET USER DATA BY EMAIL -------
  ****************************************/

  public function getUserByEmail() {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
    $req->execute( array( $this->getEmail() ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  public function updateUserMail() {

    $db   = init_db();

    $req  = $db->prepare( "UPDATE user SET email = :email WHERE id = :id;" );
    $req->execute( array(
      'email' => $this->getEmail(),
      'id' => $this->getId()
    ));

    // Close databse connection
    $db   = null;
  }

  public function updateUserPassword() {

    $db   = init_db();

    $req  = $db->prepare( "UPDATE user SET password = :password WHERE id = :id;" );
    $req->execute( array(
      'password' => hash('sha256', $this->getPassword()),
      'id' => $this->getId()
    ));

    // Close databse connection
    $db   = null;
  }

  public function deleteUser() {

    $db   = init_db();

    $req  = $db->prepare( "DELETE FROM user WHERE id = ?" );
    $req->execute( array( $this->getId() ));

    // Close databse connection
    $db   = null;
  }

}