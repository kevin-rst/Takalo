<?php

namespace app\services;

use app\repositories\ItemPhotosRepository;

class ItemsService 
{
    private $repo;

    public function __construct($repo) {
        $this->repo = $repo;
    }

    public function insert($data, $pdo, $photo) 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $photoRepo = new ItemPhotosRepository($pdo);

        $id = $this->repo->create($data['title'], $data['description'], $data['category'], $_SESSION['users']['id'], $data['price']);
        $photoRepo->create($photo, $id);
    }

    public function update($data, $pdo, $photo) 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $photoRepo = new ItemPhotosRepository($pdo);

        $this->repo->update($data['title'], $data['description'], $data['category'], $_SESSION['users']['id'], $data['price'], $data['id']);
        if (!empty($photo)) {
            $id_photo = $photoRepo->getFirstPhoto($data['id'])['id'];
            $photoRepo->update($photo, $data['id'], $id_photo);
        }
    }

    public function delete($id, $pdo)
    {
        $photoRepo = new ItemPhotosRepository($pdo);
        $photoRepo->deleteByItem($id);

        $this->repo->delete($id);
    }
}