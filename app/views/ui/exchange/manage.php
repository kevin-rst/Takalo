<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des échanges</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border:1px solid #ccc; padding: 8px; text-align:left; }
    th { background-color: #f0f0f0; }
    a.button { padding: 5px 10px; background: #4CAF50; color: #fff; text-decoration: none; border-radius: 4px; }
    a.button.reject { background: #f44336; }
</style>
</head>
<body>
<h1>Demandes reçues</h1>

<?php if(!empty($received)): ?>
<table>
    <tr>
        <th>Objet proposé</th>
        <th>Votre objet</th>
        <th>De</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>
    <?php foreach($received as $d): ?>
    <tr>
        <td><?= $d['item1_title'] ?></td>
        <td><?= $d['item2_title'] ?></td>
        <td><?= $d['sender'] ?></td>
        <td>
            <?php
                if($d['id_status']==1) echo 'En attente';
                elseif($d['id_status']==2) echo 'Accepté';
                elseif($d['id_status']==3) echo 'Refusé';
            ?>
        </td>
        <td>
            <?php if($d['id_status']==1): ?>
                <a href="<?= $base_url ?>/exchange/accept/<?= $d['demand_id'] ?>" class="button">Accepter</a>
                <a href="<?= $base_url ?>/exchange/reject/<?= $d['demand_id'] ?>" class="button reject">Refuser</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>Aucune demande reçue.</p>
<?php endif; ?>

<h1>Demandes envoyées</h1>
<?php if(!empty($sent)): ?>
<table>
    <tr>
        <th>Votre objet</th>
        <th>Objet proposé</th>
        <th>À</th>
        <th>Statut</th>
    </tr>
    <?php foreach($sent as $d): ?>
    <tr>
        <td><?= $d['item1_title'] ?></td>
        <td><?= $d['item2_title'] ?></td>
        <td><?= $d['owner'] ?></td>
        <td>
            <?php
                if($d['id_status']==1) echo 'En attente';
                elseif($d['id_status']==2) echo 'Accepté';
                elseif($d['id_status']==3) echo 'Refusé';
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>Aucune demande envoyée.</p>
<?php endif; ?>
</body>
</html>