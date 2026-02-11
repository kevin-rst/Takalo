<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-Search Section</title>
</head>
<body>
    <h1>Rechercher des objets</h1>

    <form action="<?= BASE_URL ?>/item/search" method="get">
        <p>mot clé: <input type="text" name="title_part"></p>

        <p>catégorie:
            <select name="category">
                <option value=""></option>
                <?php foreach ($categories as $cat) { ?>
                    <option value="<?= $cat["id"] ?>"><?= $cat["libelle"] ?></option>
                <?php } ?>
            </select>
        </p>

        <input type="submit" value="rechercher">
    </form>

    <?php 
        if ( isset($items) ) 
        {    
            if ( !empty($items) ) { ?>
                <table border="1px">
                    <tr>
                        <td>titre</td>
                        <td>description</td>
                        <td>catégorie</td>
                        <td>propriétaire</td>
                        <td>photo</td>
                        <td>prix estimé</td>
                    </tr>

                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td><?= htmlspecialchars($item["title"]) ?></td>
                            <td><?= htmlspecialchars($item["description"]) ?></td>
                            <td><?= htmlspecialchars($item["category"]) ?></td>
                            <td><?= htmlspecialchars($item["owner"]) ?></td>
                            <td><img src="<?= htmlspecialchars($item["photo_url"]) ?>" alt="Photo of <?= htmlspecialchars($item["title"]) ?>" style="max-width:100px;"></td>
                            <td><?= htmlspecialchars($item["estimated_price"]) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?> 
                <p>Aucun objet trouvé.</p>
            <?php } 
        } ?>
    
    <p><a href="<?= BASE_URL ?>/user">retour</a></p>
</body>
</html>