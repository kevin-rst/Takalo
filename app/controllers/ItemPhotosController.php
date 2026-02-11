<?php

namespace app\controllers;

use app\repositories\ItemPhotosRepository;
use app\repositories\ItemsRepository;
use app\services\Deploy;
use flight\Engine;

class ItemPhotosController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function showForm($id)
    {
        $pdo = $this->app->db();
        $repo = new ItemPhotosRepository($pdo);
        $itemRepo = new ItemsRepository($pdo);

        $photo = $repo->findById($id);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $item = $itemRepo->findBy($photo['id_item']);
        $photos = $repo->findByItem($item['id']);

        $this->app->render('frontoffice/items/card', ['item' => $item, 'photos' => $photos, 'photo' => $photo]);
    }

    public function save()
    {
        $pdo = $this->app->db();
        $repo = new ItemPhotosRepository($pdo);

        $data = $this->app->request()->data;

        if (empty($data['id'])) {
            $photo = Deploy::upload($_FILES['photo']);
            $repo->create($photo, $data['id_item']);
        } else {
            if ($data->changePhoto == 'ok') {
                $photo = Deploy::upload($_FILES['photo']);
                $repo->update($photo, $data['id_item'], $data['id']);
            }
        }

        $this->app->redirect('/frontoffice/items/card/' . $data['id_item']);
    }

    public function delete($id)
    {
        $pdo = $this->app->db();
        $repo = new ItemPhotosRepository($pdo);

        $photo = $repo->findById($id);
        $repo->delete($id);

        $this->app->redirect('/frontoffice/items/card/' . $photo['id_item']);
    }
}
