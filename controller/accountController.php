<?php

require_once( 'model/user.php' );
require_once( 'loginController.php' );

function accountPage(){
    $user_id = $_SESSION['user_id'];

    $response = User::getUserById($user_id);

    require('view/accountView.php');
}

function updateAccount( $post ) {

    $user_id = $_SESSION['user_id'];
    $email = $post['email'];
    $password = hash('sha256', $post['password']); // Hash input password to compare with the hashed password within DB.
    $newPassword = $post['newPassword'];
    $newPasswordConfirm = $post['newPasswordConfirm'];

    $user = new User();
    $userData = $user->getUserById($user_id); // Get the current user's data in order to compare the inputs with the current data.

    // The current password is required to save new data.
    if ($password != $userData['password'])
    {
        $error_msg = "Le mot de passe actuel est erroné.";
    }
    elseif (isset($_POST['changeMail']))
    {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email))
        {
            $error_msg = "Format de mail non valide.";
        }
        else
        {
            $user->setId($user_id);
            $user->setEmail($email);

            $userData = $user->getUserByEmail();

            if ($userData && sizeof( $userData ) > 0) // If email address is already in used, show error.
            {
                $error_msg = "Cette adresse mail est déjà utilisée.";
            }
            else
            {
                $user->updateUserMail();
                $success_msg = "Vos informations ont été modifiées avec succès.";
            }    
        }
    }
    elseif (isset($_POST['changePassword']))
    {
        if (strlen($newPassword) < 6)
        {
            $error_msg = "Nouveau mot de passe incorrect. Min. 6 caractères.";
        }
        elseif ($newPassword != $newPasswordConfirm)
        {
            $error_msg = "Les nouveaux mots de passe ne correspondent pas.";
        }
        else
        {
            $user->setId($user_id);
            $user->setPassword($newPassword);

            $user->updateUserPassword();
            $success_msg = "Vos informations ont été modifiées avec succès.";     
        }
    }

    require('view/accountView.php');
}

function deleteAccount($post){

    $user_id = $_SESSION['user_id'];
    $password = hash('sha256', $post['password']);

    $user = new User();
    $userData = $user->getUserById($user_id); // Get the current user's data in order to compare the inputs with the current data.

    // The current password is required to save new data.
    if ($password != $userData['password']) {
        $error_msg = "Le mot de passe actuel est erroné.";
    }
    else{
        // var_dump("ÊTES VOUS SUR DE VOULOIR SUPPRIMER VOTRE COMPTE ? CETTE ACTION EST IRREVERSIBLE !");
        // Afficher une modal de confirmation ? => bootstrap
        $user->setId($user_id);
        $user->deleteUser();
        logOut(); // Logging out the current user once the account has been successfully deleted.
    }

    require('view/accountView.php');
}