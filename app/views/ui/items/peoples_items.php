<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir les objets des autres et échanger</title>
</head>
<body>
    <?php
        if(isset($items) && !empty($items))
            {
            foreach($items as $item)
                {
                ?>
                <div>
                    <p>Titre: <?= $item['title'] ?></p>
                    <p>Déscription: <?= $item['description'] ?></p>
                    <p>Catégorie: <?= $item['category_libelle'] ?></p>
                    <p>Posté le: <?= $item['created_at'] ?></p>
                    <p>Prix estimé: <?= $item['estimated_price'] ?></p>
                    </a>
                    <p>Propriétaire: <?= $item['owner_username'] ?></p>
                </div>
                <?php
            }
        }
    
    
    ?>
</body>
</html>