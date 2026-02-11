<?php
require_once(__DIR__ . "/../../includes/utils.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Connexion</h4>
          </div>
          <div class="card-body">

            <?php if (!empty($success)): ?>
              <div class="alert alert-success">Connexion réussie ✅</div>
            <?php endif; ?>

            <form id="loginForm" method="post" action="<?= BASE_URL ?>/login" novalidate>
              <div id="formStatus" class="alert d-none"></div>

              <div class="mb-3">
                <label for="nom" class="form-label">Nom d'utilisateur</label>
                <input id="nom" name="nom" class="form-control <?= cls_invalid($errors, 'nom') ?>" value="<?= e($values['nom'] ?? '') ?>">
                <div class="invalid-feedback" id="nomError"><?= e($errors['nom'] ?? '') ?></div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" name="password" type="password" class="form-control <?= cls_invalid($errors, 'password') ?>">
                <div class="invalid-feedback" id="passwordError"><?= e($errors['password'] ?? '') ?></div>
              </div>

              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmation</label>
                <input id="confirm_password" name="confirm_password" type="password" class="form-control <?= cls_invalid($errors, 'confirm_password') ?>">
                <div class="invalid-feedback" id="confirmPasswordError"><?= e($errors['confirm_password'] ?? '') ?></div>
              </div>

              <button class="btn btn-primary w-100" type="submit">Se connecter</button>
              <br><br>

              <a href="<?= BASE_URL ?>/register" style="text-decoration: none;">Inscription</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>