<?php ob_start(); ?>

<div id="home">
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title">Cod<span>'Flix</span></h1>
                    <p>
                        <strong>Bienvenue</strong>
                    </p>
                </div>
            </div>
            <div class="row btn-container">
                <div class="col-md-6"><a href="index.php?action=login" class="btn btn-block bg-red">Connexion</a></div>
                <div class="col-md-6"><a href="index.php?action=signup" class="btn btn-block bg-blue">Inscription</a></div>
            </div>

            <!-- <div class="row btn-container">
                <div class="col-md-2 m-auto"><a href="index.php?action=contact" class="btn bg-white text-dark">Nous contacter</a></div>
            </div> -->
        </div>
        <a href="index.php?action=contact" class="btn bg-white btn-contact">Nous contacter</a>
    </div>    
</div>

<?php $content = ob_get_clean(); ?>

<?php require('base.php'); ?>
