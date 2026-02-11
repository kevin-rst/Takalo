<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateur</title>
</head>
<body>
    <h1>Utilisateur: <?= $_SESSION['users']['username'] ?></h1>

    <a href="<?= BASE_URL ?>/logout">Se deconnecter</a>
</body>
</html>