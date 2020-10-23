<?php ob_start(); ?>

      <div class="col-md-12 full-height bg-white" >
        <div class="auth-container">
          <h2><span>Cod</span>'Flix</h2>
          <h3>Mon compte</h3>

          <form method="post" class="custom-form">

            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                    <label for="password">Mot de passe actuel</label>
                    <input type="password" name="password" id="password" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="email">Adresse email</label>
                  <input type="email" name="email" id="email" class="form-control" />
                </div>

                <div class="mb-5">
                    <input type="submit" name="changeMail" value="Modifier mon email" class="btn btn-block bg-blue" />
                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">
                  <label for="newPassword">Nouveau mot de passe</label>
                  <input type="password" name="newPassword" id="newPassword" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="newPasswordConfirm">Confirmer nouveau mot de passe</label>
                  <input type="password" name="newPasswordConfirm" id="newPasswordConfirm" class="form-control" />
                </div>

                <div>
                    <input type="submit" name="changePassword" value="Modifier mon mot de passe" class="btn btn-block bg-blue" />
                </div>

              </div>
            </div>
            
            <span class="error-msg">
              <?= isset( $error_msg ) ? $error_msg : null; ?>
            </span>
            <span class="success-msg">
              <?= isset( $success_msg ) ? $success_msg : null; ?>
            </span>

            <div class="row">

              <div class="col-md-6">
                <input type="submit" name="deleteAccount" value="Supprimer mon compte" class="btn btn-block bg-red" />
              </div>
              
              <div class="col-md-6">
                <a href="index.php" class="btn btn-block bg-red cold-md-6">Retour</a>
              </div>

            </div>

          </form>
        </div>
      </div>

<?php $content = ob_get_clean(); ?>

<?php require( __DIR__ . './base.php'); ?>