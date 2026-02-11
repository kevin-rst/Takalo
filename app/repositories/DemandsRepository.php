<?php

namespace app\repositories;

use PDO;

class DemandsRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDemandsWithOnesObjet($id_item1, $item2_id_owner)
    {
        $query = "SELECT * FROM demands_with_items_first_photo WHERE id_item1 = ? AND item2_id_owner = ? AND status_libelle = 'En attente'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_item1, $item2_id_owner]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($item1, $item2, $id_status)
    {
        $query = "INSERT INTO takalo_demands (id_item1, id_item2, id_status) VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$item1, $item2, $id_status]);
    }

    public function list($item2_id, $status)
    {
        $query = "SELECT * FROM demands_with_items_first_photo WHERE item2_id_owner = ? AND status_libelle = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$item2_id, $status]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function accept($id, $id_accept_status)
    {
        $query = "UPDATE takalo_demands SET id_status = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_accept_status, $id]);
    }

    public function deny($id, $id_deny_status)
    {
        $query = "UPDATE takalo_demands SET id_status = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_deny_status, $id]);
    }

    public function findById($id)
    {
        $query = "SELECT * FROM takalo_demands WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([ $id ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
