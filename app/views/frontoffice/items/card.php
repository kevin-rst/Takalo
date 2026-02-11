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
    <title>Fiche objet</title>
</head>

<body>
    <div>
        <p>Titre: <?= $item['title'] ?></p>
        <p>Déscription: <?= $item['description'] ?></p>
        <p>Catégorie: <?= $item['category_libelle'] ?></p>
        <p>Posté le: <?= $item['created_at'] ?></p>
        <p>Prix estimé: <?= $item['estimated_price'] ?></p>
        <img style="max-width: 200px; max-height: 200px;" src="<?= BASE_URL ?>/public/images/<?= $item['photo_url'] ?>" alt="">
        <br>
        <?php if ($item['id_owner'] == $_SESSION['users']['id']) { ?>
            <a href="<?= BASE_URL ?>/frontoffice/items/showForm/<?= $item['id'] ?>"><input type="button" value="Modifier"></a>
            <a href="<?= BASE_URL ?>/frontoffice/items/delete/<?= $item['id'] ?>"><input type="button" value="Supprimer"></a>
        <?php } ?>
    </div>
    <br>

    <?php if ($item['id_owner'] == $_SESSION['users']['id']) { ?>
        <h3>Formulaire de photo</h3>
        <form action="<?= BASE_URL ?>/frontoffice/itemPhotos/save" method="post" enctype="multipart/form-data">
            <label for="photo">Photo:</label>
            <input type="file" name="photo" id="photo"><br><br>

            <input type="hidden" name="id" value="<?= isset($photo) ? $photo['id'] : '' ?>">
            <input type="hidden" name="id_item" value="<?= $item['id'] ?>">

            <?php if (isset($photo)) { ?>
                <input type="checkbox" name="changePhoto" value="ok" id="">Changer la photo ?
            <?php } ?>
            <br><br>

            <input type="submit" value="Valider">
        </form>
    <?php } ?>
    <br>

    <h3>Voici toutes les photos</h3>
    <?php foreach ($photos as $element) { ?>
        <div>
            <img style="width: 400px; height: 350px;" src="<?= BASE_URL ?>/public/images/<?= $element['url'] ?>" alt="">
            <?php if ($item['id_owner'] == $_SESSION['users']['id']) { ?>
                <a href="<?= BASE_URL ?>/frontoffice/itemPhotos/showForm/<?= $element['id'] ?>"><input type="button" value="Modifier"></a>
                <a href="<?= BASE_URL ?>/frontoffice/itemPhotos/delete/<?= $element['id'] ?>"><input type="button" value="Supprimer"></a>
            <?php } ?>
        </div>
    <?php } ?>
    <br>

    <?php if ($item['id_owner'] != $_SESSION['users']['id']) {
        if (isset($demands) && !empty($demands)) { ?>
            <h3>Voici vos objets cibles</h3>
            <?php foreach ($demands as $element) { ?>
                <div>
                    <p>Titre: <?= $element['item2_title'] ?></p>
                    <p>Déscription: <?= $element['item2_description'] ?></p>
                    <p>Catégorie: <?= $element['item2_category_libelle'] ?></p>
                    <p>Posté le: <?= $element['item2_created_at'] ?></p>
                    <p>Prix estimé: <?= $element['item2_estimated_price'] ?></p>
                    <img style="max-width: 200px; max-height: 200px;" src="<?= BASE_URL ?>/public/images/<?= $element['item2_photo_url'] ?>" alt="">
                    <br>
                    <a href="<?= BASE_URL ?>/frontoffice/items/showForm/<?= $element['item2_id'] ?>"><input type="button" value="Modifier"></a>
                    <a href="<?= BASE_URL ?>/frontoffice/items/delete/<?= $element['item2_id'] ?>"><input type="button" value="Supprimer"></a>
                </div>
            <?php }
        } else { ?>
            <p>Aucun de vos objets n'est cible</p>
    <?php }
    } ?>

    <?php $url = ($item['id_owner'] == $_SESSION['users']['id']) ? "oneself" : "others" ?>
    <br>
    <a href="<?= BASE_URL ?>/frontoffice/items/<?= $url ?>"><input type="button" value="Retour"></a>

</body>

</html>