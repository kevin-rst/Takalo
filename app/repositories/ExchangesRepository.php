<?php

namespace app\repositories;

use PDO;

class ExchangesRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($item1, $item2)
    {
        $query = "INSERT INTO takalo_exchanges (id_item1, id_item2) VALUES (?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $item1, $item2 ]);
    }
}
