<?php 
namespace app\repositories;
use PDO;

class PeoplesItemsRepository {
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllItems($current_id) {
        $query = "SELECT 
                    takalo_items.*,
                    takalo_categories.libelle AS category_libelle,
                    takalo_photos.url AS photo_url,
                    takalo_users.username AS owner_username
                  FROM takalo_items
                  JOIN takalo_categories ON takalo_items.id_category = takalo_categories.id
                  JOIN takalo_users ON takalo_items.id_owner = takalo_users.id
                  LEFT JOIN takalo_photos ON takalo_items.id_photo = takalo_photos.id
                  WHERE id_owner != ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$current_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMyItems($current_id) {
        $query = "SELECT id, title FROM takalo_items WHERE id_owner = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$current_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function proposeExchange($item1_id, $item2_id)
    {
        $status_id = 1; // En attente
        $query = "INSERT INTO takalo_demands (id_item1, id_item2, id_status) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$item1_id, $item2_id, $status_id]);
    }

public function getSentDemands($userId)
{
    $query = "
    SELECT d.id, d.id_item1, d.id_item2, d.id_status, d.created_at,
           i1.title AS my_item, i2.title AS other_item,
           u.username AS other_user
    FROM takalo_demands d
    JOIN takalo_items i1 ON d.id_item1 = i1.id
    JOIN takalo_items i2 ON d.id_item2 = i2.id
    JOIN takalo_users u ON i2.id_owner = u.id
    WHERE i1.id_owner = ?
    ";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getReceivedDemands($userId)
{
    $query = "
    SELECT d.id, d.id_item1, d.id_item2, d.id_status, d.created_at,
           i1.title AS other_item, i2.title AS my_item,
           u.username AS other_user
    FROM takalo_demands d
    JOIN takalo_items i1 ON d.id_item1 = i1.id
    JOIN takalo_items i2 ON d.id_item2 = i2.id
    JOIN takalo_users u ON i1.id_owner = u.id
    WHERE i2.id_owner = ?
    ";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function updateDemandStatus($demandId, $action)
{
    $status = $action === 'accept' ? 2 : 3; // 2 = accepté, 3 = refusé
    $query = "UPDATE takalo_demands SET id_status = ? WHERE id = ?";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$status, $demandId]);

    if($action === 'accept') 
        {
        $stmt2 = $this->pdo->prepare("
            INSERT INTO takalo_exchanges (id_item1, id_item2)
            SELECT id_item1, id_item2 FROM takalo_demands WHERE id = ?
        ");
        $stmt2->execute([$demandId]);
    }
}
}
?>