<?php

namespace app\services;

use app\repositories\DemandStatusRepository;
use app\repositories\ExchangesRepository;
use app\repositories\ItemsRepository;

class DemandsService 
{
    private $repo;

    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    public function accept($id, $pdo)
    {
        $statusRepo = new DemandStatusRepository($pdo);
        $id_accept_status = $statusRepo->getStatus("Acceptée")['id'];

        $this->repo->accept($id, $id_accept_status);
        $demand = $this->repo->findById($id);

        $itemRepo = new ItemsRepository($pdo);
        $item1_new_id_owner = $itemRepo->findBy($demand['id_item2'])['id_owner'];
        $item2_new_id_owner = $itemRepo->findBy($demand['id_item1'])['id_owner'];

        $itemRepo->changeOwner($demand['id_item1'], $item1_new_id_owner);
        $itemRepo->changeOwner($demand['id_item2'], $item2_new_id_owner);

        $exchangesRepo = new ExchangesRepository($pdo);
        $exchangesRepo->create($demand['id_item1'], $demand['id_item2']);
    }
}