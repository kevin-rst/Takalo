<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objets à échanger</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .item { border:1px solid #ccc; margin-bottom:10px; padding:10px; display:flex; gap:10px; }
        .item img { width: 100px; height: 100px; object-fit: cover; }
        .item-details { flex-grow: 1; }
        .my-item { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h1>Objets des autres utilisateurs</h1>

    <?php if(!empty($items)): ?>
        <?php foreach($items as $item): ?>
            <div class="item">
                <?php if(!empty($item['photo_url'])): ?>
                    <img src="<?= $item['photo_url'] ?>" alt="<?= $item['title'] ?>">
                <?php endif; ?>
                <div class="item-details">
                    <p><strong>Titre:</strong> <?= $item['title'] ?></p>
                    <p><strong>Description:</strong> <?= $item['description'] ?></p>
                    <p><strong>Catégorie:</strong> <?= $item['category_libelle'] ?></p>
                    <p><strong>Posté le:</strong> <?= $item['created_at'] ?></p>
                    <p><strong>Prix estimé:</strong> <?= $item['estimated_price'] ?></p>
                    <p><strong>Propriétaire:</strong> <?= $item['owner_username'] ?></p>

                    <form action="<?= $base_url ?>/ui/items/<?= $item['id'] ?>" method="GET">
                        <button type="submit">Proposer un échange</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun objet disponible.</p>
    <?php endif; ?>

    <?php if(!empty($myItems) && $selectedItem1 !== null): ?>
        <h2>Choisir votre objet pour l’échange</h2>
        <form action="<?= $base_url ?>/exchange/propose" method="POST">
            <input type="hidden" name="item1_id" value="<?= $selectedItem1 ?>">
            <?php foreach($myItems as $myItem): ?>
                <div class="my-item">
                    <input type="radio" name="item2_id" value="<?= $myItem['id'] ?>" required>
                    <?= $myItem['title'] ?>
                </div>
            <?php endforeach; ?>
            <button type="submit">Envoyer la demande</button>
        </form>
    <?php endif; ?>
</body>
</html>