<?php

namespace app\controllers;

use app\repositories\ItemPhotosRepository;
use app\repositories\ItemsRepository;
use app\repositories\ItemCategoriesRepository;
use app\services\ItemsService;
use app\services\Deploy;
use flight\Engine;

class ItemsController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function listOneselfItems()
    {
        $pdo = $this->app->db();
        $repo = new ItemsRepository($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $list = $repo->list($_SESSION['users']['id']);

        $this->app->render('frontoffice/items/oneselfItems.php', [ 'items' => $list ]);
    }

    public function showForm() {
        $pdo = $this->app->db();
        $catRepo = new ItemCategoriesRepository($pdo);

        $categories = $catRepo->list();

        $this->app->render('frontoffice/items/form', [ 'itemCategories' => $categories ]);
    }

    public function showSpecifiedForm($id) {
        $pdo = $this->app->db();
        $repo = new ItemsRepository($pdo);
        $catRepo = new ItemCategoriesRepository($pdo);

        $categories = $catRepo->list();
        $item = $repo->findById($id);

        $this->app->render('frontoffice/items/form', [ 'itemCategories' => $categories, 'item' => $item ]);
    }

    public function save() {
        $pdo = $this->app->db();
        $repo = new ItemsRepository($pdo);
        $svc = new ItemsService($repo);

        $data = $this->app->request()->data;

        if (empty($data['id'])) {
            $photo = Deploy::upload($_FILES['photo']);
            $svc->insert($data, $pdo, $photo);
        } else {
            $photo = ($data->changePhoto == 'ok') ? Deploy::upload($_FILES['photo']) : '';
            $svc->update($data, $pdo, $photo);
        }

        $this->app->redirect('/frontoffice/items/oneself');
    }

    public function delete($id)
    {
        $pdo = $this->app->db();
        $repo = new ItemsRepository($pdo);
        $svc = new ItemsService($repo);

        $svc->delete($id, $pdo);

        $this->app->redirect('/frontoffice/items/oneself');
    }
}
