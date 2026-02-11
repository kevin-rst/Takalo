<?php

namespace app\controllers;

use flight\Engine;
use app\models\CategoryModel;

class CategoryController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getAllCategories() {
        $CategoryModel = new CategoryModel($this->app->db());
        $categories = $CategoryModel->getAllCategories();

        $this->app->render('frontoffice/item/filter', ['categories' => $categories]);
    }
}