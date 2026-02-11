<?php

namespace app\repositories;

use PDO;

class ItemCategoriesRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function list()
    {
        $query = "SELECT * FROM takalo_item_categories ORDER BY libelle";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($libelle)
    {
        $query = "INSERT INTO takalo_item_categories (libelle) VALUES (?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $libelle ]);
    }

    public function update($id, $libelle)
    {
        $query = "UPDATE takalo_item_categories SET libelle = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $libelle, $id ]);
    }

    public function getById($id) 
    {
        $query = "SELECT * FROM takalo_item_categories WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM takalo_item_categories WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);
    }
}

