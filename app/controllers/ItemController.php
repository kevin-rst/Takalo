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

    public function prepare($item2_id = null)
    {
        $pdo = $this->app->db();
        $itemRepo = new PeoplesItemsRepository($pdo);
    
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $userId = $_SESSION['users']['id'];

        $items = $itemRepo->getAllItems($userId);
    
        $myItems = $itemRepo->getMyItems($userId);
    
        $base_url = $this->app->get('flight.base_url');
    
        $this->app->render('ui/items/peoples_items', [
            'items' => $items,
            'myItems' => $myItems,
            'selectedItem1' => $item2_id,
            'base_url' => $base_url
        ]);
    }
}
?>