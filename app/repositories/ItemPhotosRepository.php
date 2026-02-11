<?php

namespace app\repositories;

use PDO;

class ItemPhotosRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($url, $id_item) 
    {
        $query = "INSERT INTO takalo_item_photos (url, id_item) VALUES (?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $url, $id_item ]);
    }

    public function update($url, $id_item, $id)
    {
        $query = "UPDATE takalo_item_photos SET url = ?, id_item = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $url, $id_item, $id ]);
    }

    public function getFirstPhoto($id_item)
    {
        $query = "SELECT * FROM takalo_item_photos WHERE id_item = ? ORDER BY id LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id_item ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteByItem($id_item)
    {
        $query = "DELETE FROM takalo_item_photos WHERE id_item = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id_item ]);
    }

    public function findByItem($id_item) {
        $query = "SELECT * FROM takalo_item_photos WHERE id_item = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id_item ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT * FROM takalo_item_photos WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $query = "DELETE FROM takalo_item_photos WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);
    }

}

