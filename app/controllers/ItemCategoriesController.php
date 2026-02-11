<?php

namespace app\controllers;

use app\repositories\ItemCategoriesRepository;
use flight\Engine;

class ItemCategoriesController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function list()
    {
        $pdo = $this->app->db();
        $repo = new ItemCategoriesRepository($pdo);
        $list = $repo->list();

        $this->app->render('backoffice/categories/list', ['itemCategories' => $list]);
    }

    public function save() {
        $pdo = $this->app->db();
        $repo = new ItemCategoriesRepository($pdo);

        $data = $this->app->request()->data;

        $id = $data->id;
        $libelle = $data->libelle;

        if (empty($id)) {
            $repo->create($libelle);
        } else {
            $repo->update($id, $libelle);
        }

        $this->app->redirect('backoffice/categories/list');
    }

    public function showForm($id) {
        $pdo = $this->app->db();
        $repo = new ItemCategoriesRepository($pdo);

        $itemCategory = $repo->getById($id);
        $list = $repo->list();
        
        $this->app->render('backoffice/categories/list', [ 'itemCategories' => $list, 'itemCategory' => $itemCategory ]);
    }

    public function delete($id) {
        $pdo = $this->app->db();
        $repo = new ItemCategoriesRepository($pdo);

        $repo->delete($id);

        $this->app->redirect('backoffice/categories/list');
    }
}
