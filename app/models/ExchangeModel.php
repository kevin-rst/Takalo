<?php 

namespace app\models;
use PDO;

class ExchangeModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getExchangesMade() {
        $query = "SELECT COUNT(*) as exchanges_number FROM takalo_exchanges";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllExchangesById($id) {
        $query = "SELECT ex.id as exchange_id,
        vid1.title as item1_title, vid1.category as item1_category, vid1.description as item1_description, vid1.photo_url as item1_image_url, vid1.owner as item1_username,
        vid2.title as item2_title, vid2.category as item2_category, vid2.description as item2_description, vid2.photo_url as item2_image_url, vid2.owner as item2_username,
        ex.created_at as exchange_date             
        FROM takalo_exchanges ex JOIN v_item_details vid1
        ON ex.id_item1 = vid1.item_id JOIN v_item_details vid2 
        ON ex.id_item2 = vid2.item_id WHERE ex.id_item1 = ? OR ex.id_item2 = ? ORDER BY ex.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id, $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}