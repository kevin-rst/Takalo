<?php

namespace app\controllers;

use flight\Engine;
use app\models\ExchangeModel;

class ExchangeController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getAllExchangesById($id_item) {
        $exchangeModel = new ExchangeModel($this->app->db());
        $exchanges = $exchangeModel->getAllExchangesById($id_item);

        $this->app->render('frontoffice/item/history-detail', [ 'exchanges' => $exchanges ]);
    }
}