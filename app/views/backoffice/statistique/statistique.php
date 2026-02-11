<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Statistique</title>
</head>
<body>
    <h1>STATISTIQUE</h1>

    <?php if ($user_number ==0) { ?>
        <p>Aucun utilisateur inscrit...</p>
    <?php } else { ?>
        <p><?= $user_number ?> inscrits</p>
    <?php } ?>

    <?php if ($exchange_number ==0) { ?>
        <p>Aucune échanges effectuées...</p>
    <?php } else { ?>
        <p><?= $exchange_number ?> effectuées</p>
    <?php } ?>
</body>
</html>