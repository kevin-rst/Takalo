<?php

namespace app\repositories;

use PDO;

class DemandStatusRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getStatus($libelle) 
    {
        $query = "SELECT * FROM takalo_demand_status WHERE libelle = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $libelle ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
