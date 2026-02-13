<?php
namespace app\controllers;

use flight\Engine;
use PDO;

class ExchangeController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function manage()
    {
        $pdo = $this->app->db();
        $user_id = $_SESSION['users']['id'];

        $stmt = $pdo->prepare("
            SELECT d.id as demand_id, d.id_item1, d.id_item2, d.id_status, d.created_at,
                   i1.title AS item1_title, i2.title AS item2_title,
                   u1.username AS sender, u2.username AS owner
            FROM takalo_demands d
            JOIN takalo_items i1 ON d.id_item1 = i1.id
            JOIN takalo_items i2 ON d.id_item2 = i2.id
            JOIN takalo_users u1 ON i1.id_owner = u1.id
            JOIN takalo_users u2 ON i2.id_owner = u2.id
            WHERE i2.id_owner = ?
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([$user_id]);
        $received = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("
            SELECT d.id as demand_id, d.id_item1, d.id_item2, d.id_status, d.created_at,
                   i1.title AS item1_title, i2.title AS item2_title,
                   u1.username AS sender, u2.username AS owner
            FROM takalo_demands d
            JOIN takalo_items i1 ON d.id_item1 = i1.id
            JOIN takalo_items i2 ON d.id_item2 = i2.id
            JOIN takalo_users u1 ON i1.id_owner = u1.id
            JOIN takalo_users u2 ON i2.id_owner = u2.id
            WHERE i1.id_owner = ?
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([$user_id]);
        $sent = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $base_url = $this->app->get('flight.base_url');

        $this->app->render('ui/exchange/manage', [
            'received' => $received,
            'sent' => $sent,
            'base_url' => $base_url
        ]);
    }

    public function accept($demand_id)
    {
        $pdo = $this->app->db();

        $stmt = $pdo->prepare("SELECT id_item1, id_item2 FROM takalo_demands WHERE id = ?");
        $stmt->execute([$demand_id]);
        $demand = $stmt->fetch(PDO::FETCH_ASSOC);

        if($demand){
            $item1_id = $demand['id_item1'];
            $item2_id = $demand['id_item2'];

            $stmt = $pdo->prepare("SELECT id_owner FROM takalo_items WHERE id = ?");
            $stmt->execute([$item1_id]);
            $owner1 = $stmt->fetchColumn();

            $stmt->execute([$item2_id]);
            $owner2 = $stmt->fetchColumn();

            $stmt = $pdo->prepare("UPDATE takalo_items SET id_owner = ? WHERE id = ?");
            $stmt->execute([$owner2, $item1_id]);
            $stmt->execute([$owner1, $item2_id]);

            $stmt = $pdo->prepare("UPDATE takalo_demands SET id_status = 2 WHERE id = ?");
            $stmt->execute([$demand_id]);
        }

        $this->app->redirect($this->app->get('flight.base_url') . '/exchange/manage');
    }

    public function reject($demand_id)
    {
        $pdo = $this->app->db();

        $stmt = $pdo->prepare("UPDATE takalo_demands SET id_status = 3 WHERE id = ?");
        $stmt->execute([$demand_id]);

        $this->app->redirect($this->app->get('flight.base_url') . '/exchange/manage');
    }
}