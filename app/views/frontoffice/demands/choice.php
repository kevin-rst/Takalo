<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande</title>
</head>

<body>
    <h2>Choisir parmi vos objets pour l'échange</h2>
    <form action="<?= BASE_URL ?>/frontoffice/demands/demand" method="post">
        <input type="hidden" name="item2_id" value="<?= $item2_id ?>">

        <?php foreach ($items as $element) { ?>
            <label for="item1_id_<?= $element['id'] ?>">
                <input type="radio" name="item1_id" id="item1_id_<?= $element['id'] ?>" value="<?= $element['id'] ?>">
                <div>
                    <p>Titre: <?= $element['title'] ?></p>
                    <p>Déscription: <?= $element['description'] ?></p>
                    <p>Catégorie: <?= $element['category_libelle'] ?></p>
                    <p>Posté le: <?= $element['created_at'] ?></p>
                    <p>Prix estimé: <?= $element['estimated_price'] ?></p>
                    <img style="max-width: 200px; max-height: 200px;" src="<?= BASE_URL ?>/public/images/<?= $element['photo_url'] ?>" alt="">
                </div>
            </label><br><br>
        <?php } ?>

        <input type="submit" value="Valider">
    </form>

    <br>
    <a href="<?= BASE_URL ?>/frontoffice/items/others"><input type="button" value="Retour"></a>
</body>

</html>