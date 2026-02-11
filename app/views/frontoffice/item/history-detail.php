<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Détails des échanges</h1>

    <?php if (empty($exchanges)) { ?>
        <p>Aucun échange trouvé pour cet objet.</p>
    <?php } else { ?>
        <table border="1px">
            <tr>
                <th>Utilisateur 1</th>
                <th>Utilisateur 2</th>
                <th>Objet 1</th>
                <th>Objet 2</th>
                <th>Date de l'échange</th>
            </tr>
            <?php foreach ($exchanges as $exchange) { ?>
                <tr>
                    <td><?= $exchange['item1_username'] ?></td>
                    <td><?= $exchange['item2_username'] ?></td>
                    <td><?= $exchange['item1_title'] ?></td>
                    <td><?= $exchange['item2_title'] ?></td>
                    <td><?= $exchange['exchange_date'] ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <p><a href="<?= BASE_URL ?>/item/list">retour</a></p>
</body>
</html>