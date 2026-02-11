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
}