<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() use ($app) {
		$app->render('home/index');
	});

}, [ SecurityHeadersMiddleware::class ]);

$router->get('/ui/@id', function($id) use ($app) {
    $controller = new \app\controllers\ItemController($app);
    $controller->prepare($id);
});