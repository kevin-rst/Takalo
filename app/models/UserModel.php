<?php 

namespace app\models;
use PDO;

class UserModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUsersRegistered() {
        $query = "SELECT COUNT(*) AS users_number FROM takalo_users";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}