<?php ob_start(); ?>

<div class="landscape">
  <div class="bg-black">
    <div class="row no-gutters">
      <div class="col-md-6 full-height bg-white">
        <div class="auth-container">
          <h2><span>Cod</span>'Flix</h2>
          <h3>Contact</h3>

          <form method="post" class="custom-form">

            <div class="form-group">
              <label for="email">Adresse email</label>
              <input type="email" name="email" id="email" class="form-control" />
            </div>

            <div class="form-group">
              <label for="message">Votre message</label>
              <textarea name="message" id="message" class="form-control" rows="7"></textarea>
            </div>

            <div class="form-group">
              <div class="row">

                <div class="col-md-6">
                  <input type="submit" name="Valider" class="btn btn-block bg-red" />
                </div>

                <div class="col-md-6">
                  <a href="index.php" class="btn btn-block bg-red">Retour</a>
                </div>
                
              </div>
            </div>

            <span class="error-msg">
              <?= isset( $error_msg ) ? $error_msg : null; ?>
            </span>
            <span class="success-msg">
              <?= isset( $success_msg ) ? $success_msg : null; ?>
            </span>
          </form>

          
        </div>
      </div>
      <div class="col-md-6 full-height">
        <div class="auth-container">
          <h1>Ecrivez-nous !</h1>
        </div>
      </div>
    </div>
  </div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require( __DIR__ . './base.php'); ?>