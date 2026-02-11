<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes</title>
</head>

<body>
    <?php if (isset($demands) && !empty($demands)) { ?>
        <h3>Voici la liste des demandes qui vous concernent</h3>

        <?php foreach ($demands as $element) { ?>
            <div>
                <p>Titre: <?= $element['item1_title'] ?></p>
                <p>Déscription: <?= $element['item1_description'] ?></p>
                <p>Catégorie: <?= $element['item1_category_libelle'] ?></p>
                <p>Posté le: <?= $element['item1_created_at'] ?></p>
                <p>Prix estimé: <?= $element['item1_estimated_price'] ?></p>
                <img style="max-width: 200px; max-height: 200px;" src="<?= BASE_URL ?>/public/images/<?= $element['item1_photo_url'] ?>" alt="">
                <p>Propriétaire: <?= $element['item1_owner_username'] ?></p>
                <a href="<?= BASE_URL ?>/frontoffice/demands/accept/<?= $element['demand_id'] ?>"><input type="button" value="Accepter"></a>
                <a href="<?= BASE_URL ?>/frontoffice/demands/deny/<?= $element['demand_id'] ?>"><input type="button" value="Refuser"></a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>Aucune demande réçue</p>
    <?php } ?>

</body>

</html>