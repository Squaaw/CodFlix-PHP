<?php ob_start(); ?>

      <div class="col-md-12 full-height bg-white">
        <div class="auth-container">
          <h2><span>Cod</span>'Flix</h2>
          <h3>Activation</h3>

          <form class="custom-form">

            <span class="error-msg">
              <?= isset( $error_msg ) ? $error_msg : null; ?>
            </span>

            <span class="success-msg">
              <?= isset( $success_msg ) ? $success_msg : null; ?>
            </span>

            <div class="d-flex justify-content-center mt-4">
                <a href="index.php" class="btn bg-red">Accueil</a>
            </div>

          </form>
            
        </div>
      </div>

<?php $content = ob_get_clean(); ?>

<?php require( __DIR__ . './base.php'); ?>