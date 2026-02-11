<?php 

namespace app\models;
use PDO;

class CategoryModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM takalo_item_categories";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}