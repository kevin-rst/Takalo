<?php

namespace app\controllers;

use app\repositories\DemandsRepository;
use app\repositories\DemandStatusRepository;
use app\repositories\ItemsRepository;
use app\services\DemandsService;
use flight\Engine;

class DemandsController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function prepare($item2_id)
    {
        $pdo = $this->app->db();
        $itemRepo = new ItemsRepository($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $list = $itemRepo->list($_SESSION['users']['id']);

        $this->app->render('frontoffice/demands/choice', ['items' => $list, 'item2_id' => $item2_id]);
    }

    public function demand()
    {
        $pdo = $this->app->db();
        $repo = new DemandsRepository($pdo);
        $statusRepo = new DemandStatusRepository($pdo);

        $data = $this->app->request()->data;
        $status = $statusRepo->getStatus('En attente')['id'];

        $repo->create($data->item1_id, $data->item2_id, $status);

        $this->app->redirect('/frontoffice/items/others');
    }

    public function list()
    {
        $pdo = $this->app->db();
        $repo = new DemandsRepository($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $demands = $repo->list($_SESSION['users']['id'], 'En attente');

        $this->app->render('frontoffice/demands/demand', [ 'demands' => $demands ]);
    }

    public function accept($id)
    {
        $pdo = $this->app->db();
        $repo = new DemandsRepository($pdo);
        $svc = new DemandsService($repo);

        $svc->accept($id, $pdo);

        $this->app->redirect('/frontoffice/demands');
    }

    public function deny($id) 
    {
        $pdo = $this->app->db();
        $repo = new DemandsRepository($pdo);
        $statusRepo = new DemandStatusRepository($pdo);

        $id_deny_status = $statusRepo->getStatus("Refusée")['id'];

        $repo->deny($id, $id_deny_status);

        $this->app->redirect('/frontoffice/demands');
    }
}
