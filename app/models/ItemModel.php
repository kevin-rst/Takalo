<?php 

namespace app\models;

use LDAP\Result;
use PDO;

class ItemModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllItems() {
        $query = "SELECT * FROM v_item_details";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemByCategory($category) {
        $query = "SELECT * FROM v_item_details WHERE category_id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$category]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItem($data) {
        $result = array();

        if ( $data["category"] != null ) {
            $items = $this->getItemByCategory($data["category"]);
        } else {
            $items = $this->getAllItems();
        }

        foreach ($items as $item) {
            if ( str_contains( trim(mb_strtolower($item["title"])), trim(mb_strtolower($data["title_part"])) ) ) {
                $result[] = $item;
            }
        }

        return $result;
    }
}