<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-Item History</title>
</head>
<body>
    <h1>Historique des objets</h1>

    <?php if ( $items != null ) { 
        foreach ($items as $item) { ?>
            <p><a href="<?= BASE_URL ?>/item/exchange/<?= $item["item_id"] ?>"><?= $item["title"] ?></a></p>
        <?php } ?>
    <?php } else { ?>
        <p>Aucun objet enregistré pour l'instant...</p>
    <?php } ?>

    <p><a href="<?= BASE_URL ?>/user">retour</a></p>
</body>
</html>