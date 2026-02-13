<?php
namespace app\controllers;

use app\repositories\PeoplesItemsRepository;
use flight\Engine;

class ItemController 
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    // Page principale pour voir les objets et proposer un échange
    public function prepare($item2_id)
    {
        $pdo = $this->app->db();
        $itemRepo = new PeoplesItemsRepository($pdo);
    
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Liste des objets des autres utilisateurs
        $items = $itemRepo->getAllItems($_SESSION['users']['id']);
    
        // Liste des objets de l'utilisateur actuel pour proposer un échange
        $myItems = $itemRepo->getAllItems($_SESSION['users']['id']); // Si tu veux filtrer seulement tes objets, créer une fonction spécifique
    
        // Passer base_url à la vue
        $base_url = $this->app->get('flight.base_url');
    
        $this->app->render('ui/items/peoples_items', [
            'items' => $items,
            'myItems' => $myItems,
            'selectedItem1' => $item2_id,
            'base_url' => $base_url
        ]);
    }

    // Valider la demande d'échange
    public function proposeExchange()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pdo = $this->app->db();

        $item1_id = $_POST['item1_id'] ?? null;
        $item2_id = $_POST['item2_id'] ?? null;

        if (!$item1_id || !$item2_id) {
            die('Erreur : informations manquantes.');
        }

        $stmt = $pdo->prepare("
            INSERT INTO takalo_demands (id_item1, id_item2, id_status)
            VALUES (:item1, :item2, 1)  -- 1 = En attente
        ");
        $stmt->execute([
            ':item1' => $item1_id,
            ':item2' => $item2_id
        ]);

        $this->app->redirect($this->app->get('flight.base_url') . '/ui/items');
    }
}
?>