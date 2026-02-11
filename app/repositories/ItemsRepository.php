<?php

namespace app\repositories;

use PDO;

class ItemsRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function list($id)
    {
        $query = "SELECT * FROM items_with_first_photo WHERE id_owner = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title, $description, $id_category, $id_owner, $estimated_price)
    {
        $query = "INSERT INTO takalo_items (title, description, id_category, id_owner, estimated_price) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $title, $description, $id_category, $id_owner, $estimated_price ]);

        return $this->pdo->lastInsertId();
    }

    public function update($title, $description, $id_category, $id_owner, $estimated_price, $id)
    {
        $query = "UPDATE takalo_items SET title = ?, description = ?, id_category = ?, id_owner = ?, estimated_price = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $title, $description, $id_category, $id_owner, $estimated_price, $id ]);
    }

    public function findById($id)
    {
        $query = "SELECT * FROM takalo_items WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $query = "DELETE FROM takalo_items WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);
    }
}

