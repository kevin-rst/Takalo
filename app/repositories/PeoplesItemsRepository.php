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
}
?>