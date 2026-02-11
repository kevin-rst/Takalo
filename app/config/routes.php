<?php

use app\controllers\CategoryController;
use app\controllers\ExchangeController;
use app\controllers\ItemController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\StatController;

/** 
 * @var Router $router
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() use ($app) {
		$app->render('home/index');
	});

	$router->get('/admin', function() use ($app) {
		$app->render('backoffice/admin');
	});

	$router->get('/user', function() use ($app) {
		$app->render('frontoffice/user');
	});

	$router->group('/item', function() use ($router) {

		$router->get('/showform', [ CategoryController::class, 'getAllCategories' ]);

		$router->get('/search', [ ItemController::class, 'getItem' ]);

		$router->get('/list', [ ItemController::class, 'getAllItems' ] );

		$router->get('/exchange/@id_item', [ ExchangeController::class, 'getAllExchangesById' ] );
	});

	$router->get('/statistique', [ StatController::class, 'getStatistics' ]);

}, [ SecurityHeadersMiddleware::class ]);