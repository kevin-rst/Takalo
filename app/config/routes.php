<?php

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

	$router->get('/statistique', [ StatController::class, 'getStatistics' ]);

}, [ SecurityHeadersMiddleware::class ]);