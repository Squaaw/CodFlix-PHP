<?php

/****************************
* ----- SEND CONTACT FORM -----
****************************/

function contact( $post ) {

    $email = $post['email'];
    $message = $post['message'];

    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email))
    {
        $error_msg = "Format de mail non valide.";
    }
    elseif (empty($message))
    {
        $error_msg = "Veuillez saisir votre message.";
    }
    else
    {
        sendContactMail($email, $message);
        $success_msg = "Votre message a correctement été envoyé à notre équipe. Une réponse vous sera apportée dans les plus bref délais.";
    }

    require('view/contactView.php');
}

function sendContactMail($userMail, $message) {
    $subject = "Prise de contact via le formulaire";
    $header = 'From: '.$userMail.''; // To reply to the user's message.

    //TODO: SET IN "sendmail_from" in php.ini in order to use mail().
    // mail('contact@codflix.com​', $subject, $message, $header);
}