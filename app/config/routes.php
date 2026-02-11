<?php

use app\controllers\ItemCategoriesController;
use app\controllers\ItemsController;
use app\controllers\RegisterController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\LoginController;

/** 
 * @var Router $router
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() use ($app) {
		$app->redirect('/register');
	});

	// registration
	$router->get('/register', [ RegisterController::class, 'showRegister' ]);
	$router->post('/register', [ RegisterController::class, 'postRegister' ]);

	// login
	$router->get('/login', [ LoginController::class, 'showLogin' ]);
	$router->post('/login', [ LoginController::class, 'postLogin' ]);

	// logout
	$router->get('/logout', [ LoginController::class, 'logout' ]);

	// backoffice
	$router->group('/backoffice', function() use ($router, $app) {
		$router->get('/', function () use ($app) {
			$app->render('backoffice/index');
		});

		// categories
		$router->group('/categories', function() use ($router, $app) {
			$router->get('/list', [ ItemCategoriesController::class, 'list' ]);
			$router->get('/delete/@id', [ ItemCategoriesController::class, 'delete' ]);
			$router->get('/showForm/@id', [ ItemCategoriesController::class, 'showForm' ]);
			$router->post('/save', [ ItemCategoriesController::class, 'save' ]);
		});

	});

	// frontoffice
	$router->group('/frontoffice', function() use ($router, $app) {
		$router->get('/', function() use ($app) {
			$app->render('frontoffice/index');
		});

		// objects
		$router->group('/items', function() use ($router, $app) {
			$router->get('/oneself', [ ItemsController::class, 'listOneselfItems' ]);
			$router->get('/showForm', [ ItemsController::class, 'showForm' ]);
			$router->get('/showForm/@id', [ ItemsController::class, 'showSpecifiedForm' ]);
			$router->get('/delete/@id', [ ItemsController::class, 'delete' ]);
			$router->post('/save', [ ItemsController::class, 'save' ]);
		});
	});

}, [ SecurityHeadersMiddleware::class ]);