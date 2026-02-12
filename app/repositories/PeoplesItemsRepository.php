<?php 
    namespace app\repository;
    use PDO;

class ItemRepository {
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllItems($current_id) {
        $query = "SELECT *
        FROM takalo_items
        JOIN takalo_categories ON takalo_items.id_category = takalo_categories.id
        JOIN takalo_users ON takalo_items.id_owner = takalo_users.id
        JOIN takalo_photos ON takalo_items.id_photo = takalo_photos.id where id_owner != $current_id";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$current_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}

?>