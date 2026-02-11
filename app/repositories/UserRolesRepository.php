<?php

namespace app\repositories;

use PDO;

class UserRolesRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRole($libelle) 
    {
        $query = "SELECT * FROM takalo_user_roles WHERE libelle = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([(string)$libelle]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
