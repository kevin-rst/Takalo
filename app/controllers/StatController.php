<?php

namespace app\controllers;

use flight\Engine;
use app\models\UserModel;
use app\models\ExchangeModel;

class StatController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getStatistics() {
        $UserModel = new UserModel($this->app->db());
        $user_count = $UserModel->getUsersRegistered();

        $ExchangeModel = new ExchangeModel($this->app->db());
        $exchange_count = $ExchangeModel->getExchangesMade();

        $this->app->render('backoffice/statistique/statistique', ['user_number' => $user_count['users_number'], 'exchange_number' => $exchange_count['exchanges_number']]);
    }
}