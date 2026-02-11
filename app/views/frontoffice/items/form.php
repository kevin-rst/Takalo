<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion objets</title>
</head>

<body>
    <form action="<?= BASE_URL ?>/frontoffice/items/save" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= isset($item) ? $item['id'] : '' ?>">

        <label for="title">Titre:</label>
        <input type="text" name="title" id="title" value="<?= isset($item) ? $item['title'] : '' ?>"><br><br>

        <label for="description">Déscription:</label>
        <textarea name="description" id="description" cols="40" rows="10"><?= isset($item) ? $item['description'] : '' ?></textarea><br><br>

        <label for="category">Catégorie:</label>
        <select name="category" id="category">
            <option value="">Choisir</option>
            <?php foreach ($itemCategories as $element) { ?>
                <option value="<?= $element['id'] ?>" <?= isset($item) && $item['id_category'] == $element['id'] ? 'selected' : '' ?>><?= $element['libelle'] ?></option>
            <?php } ?>
        </select><br><br>

        <label for="price">Prix estimé:</label>
        <input type="text" name="price" id="price" value="<?= isset($item) ? $item['estimated_price'] : '' ?>"><br><br>

        <label for="photo">Photo:</label>
        <input type="file" name="photo" id="photo"><br><br>

        <?php if (isset($item)) { ?>
            <input type="checkbox" name="changePhoto" value="ok" id="">Changer la photo principale ?
        <?php } ?>
        <br><br>

        <input type="submit" value="Valider">
    </form>

    <br>
    <a href="<?= BASE_URL ?>/frontoffice/items/oneself"><input type="button" value="Retour"></a>
</body>

</html>