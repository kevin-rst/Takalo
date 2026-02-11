<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objets</title>
</head>

<body>
    <a href="<?= BASE_URL ?>/frontoffice/items/showForm">Ajouter</a>

    <?php if (isset($items) && !empty($items)) { ?>
        <h2>Voici mes objets</h2>

        <?php foreach ($items as $element) { ?>
            <div>
                <p>Titre: <?= $element['title'] ?></p>
                <p>Déscription: <?= $element['description'] ?></p>
                <p>Catégorie: <?= $element['category_libelle'] ?></p>
                <p>Posté le: <?= $element['created_at'] ?></p>
                <p>Prix estimé: <?= $element['estimated_price'] ?></p>
                <img style="max-width: 200px; max-height: 200px;" src="<?= BASE_URL ?>/public/images/<?= $element['photo_url'] ?>" alt="">
                <br>
                <a href="<?= BASE_URL ?>/frontoffice/items/showForm/<?= $element['id'] ?>"><input type="button" value="Modifier"></a>
                <a href="<?= BASE_URL ?>/frontoffice/items/delete/<?= $element['id'] ?>"><input type="button" value="Supprimer"></a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>Aucun objet posté</p>
    <?php } ?>

    <a href="<?= BASE_URL ?>/frontoffice"><input type="button" value="Retour"></a>
</body>

</html>