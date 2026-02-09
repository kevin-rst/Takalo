<?php

namespace app\controllers;

use flight\Engine;

class Controller {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}
}