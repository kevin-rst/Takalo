<?php
    namespace app\controllers;

    use app\repositories\PeoplesItemsRepository;
    use app\models\Item;
    use flight\Engine;
    

    class ItemController 
    {

        protected Engine $app;
      public function __construct($app)
      {
        $this->app = $app;
      }
      public function prepare($item2_id)
    {
        $pdo = $this->app->db();
        $itemRepo = new PeoplesItemsRepository($pdo);

        if (session_status() === PHP_SESSION_NONE) 
            {
            session_start();
        }

        $list = $itemRepo->getAllItems($_SESSION['users']['id']);

        $this->app->render('ui/items/peoples_items', ['items' => $list, 'item2_id' => $item2_id]);
    }






    }





?>