<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exploration objets</title>
</head>
<body>
    <?php if (isset($items) && !empty($items)) { ?>
        <h2>Voici la liste des objets disponibles</h2>

        <?php foreach ($items as $element) { ?>
            <div>
                <p>Titre: <?= $element['title'] ?></p>
                <p>Déscription: <?= $element['description'] ?></p>
                <p>Catégorie: <?= $element['category_libelle'] ?></p>
                <p>Posté le: <?= $element['created_at'] ?></p>
                <p>Prix estimé: <?= $element['estimated_price'] ?></p>
                <a href="<?= BASE_URL ?>/frontoffice/items/card/<?= $element['id'] ?>">
                    <img style="max-width: 200px; max-height: 200px;" src="<?= BASE_URL ?>/public/images/<?= $element['photo_url'] ?>" alt="">
                </a>
                <p>Propriétaire: <?= $element['owner_username'] ?></p>
                <a href="<?= BASE_URL ?>/frontoffice/demands/prepare/<?= $element['id'] ?>">Demander un échange</a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>Aucun objet posté</p>
    <?php } ?>

    <br>
    <a href="<?= BASE_URL ?>/frontoffice"><input type="button" value="Retour"></a>
</body>
</html>