<?php

namespace app\controllers;

use flight\Engine;
use app\models\ItemModel;
use app\models\CategoryModel;

class ItemController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getItem() {
        $data = $this->app->request()->query;

        $itemModel = new ItemModel($this->app->db());
        $items = $itemModel->getItem($data);

        $categoryModel = new CategoryModel($this->app->db());
        $categories = $categoryModel->getAllCategories();

        $this->app->render('frontoffice/item/filter', [ 'items' => $items, 'categories' => $categories ]);
    }

    public function getAllItems() {
        $itemModel = new ItemModel($this->app->db());
        $items = $itemModel->getAllItems();

        $this->app->render('frontoffice/item/history', [ 'items' => $items ]);
    }
}