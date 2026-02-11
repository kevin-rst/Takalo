<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories</title>
</head>

<body>
    <h2>Formulaire de catégorie</h2>
    
    <form action="<?= BASE_URL ?>/backoffice/categories/save" method="post">
        <input type="hidden" name="id" value="<?= isset($itemCategory) ? $itemCategory['id'] : '' ?>">

        <label for="libelle">Libelle</label>
        <input type="text" name="libelle" id="libelle" value="<?= isset($itemCategory) ? $itemCategory['libelle'] : '' ?>">

        <br><br>

        <input type="submit" value="Valider">
    </form>

    <br><br>

    <?php if (isset($itemCategories) && !empty($itemCategories)) { ?>
        <h2>Voici la liste des catégories d'objet disponibles</h2>

        <table border="1">
            <tr>
                <th>Id</th>
                <th>Libelle</th>
                <th></th>
                <th></th>
            </tr>

            <?php foreach ($itemCategories as $element) { ?>
                <tr>
                    <td><?= $element['id'] ?></td>
                    <td><?= $element['libelle'] ?></td>
                    <td><a href="<?= BASE_URL ?>/backoffice/categories/showForm/<?= $element['id'] ?>"><input type="button" value="Modifier"></a></td>
                    <td><a href="<?= BASE_URL ?>/backoffice/categories/delete/<?= $element['id'] ?>"><input type="button" value="Supprimer"></a></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>Aucune catégorie disponible.</p>
    <?php } ?>

    <br>
    <a href="<?= BASE_URL ?>/backoffice"><input type="button" value="Retour"></a>
</body>

</html>