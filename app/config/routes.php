<?php

use app\controllers\DemandsController;
use app\controllers\ItemCategoriesController;
use app\controllers\ItemPhotosController;
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

		// items
		$router->group('/items', function() use ($router, $app) {
			// oneself
			$router->get('/oneself', [ ItemsController::class, 'listOneselfItems' ]);
			$router->get('/showForm', [ ItemsController::class, 'showForm' ]);
			$router->get('/showForm/@id', [ ItemsController::class, 'showSpecifiedForm' ]);
			$router->get('/delete/@id', [ ItemsController::class, 'delete' ]);
			$router->post('/save', [ ItemsController::class, 'save' ]);
			$router->get('/card/@id', [ ItemsController::class, 'showCard' ]);

			// others
			$router->get('/others', [ ItemsController::class, 'listOthersItems' ]);
		});

		// demands
		$router->group('/demands', function() use ($router, $app) {
			$router->get('/', [ DemandsController::class, 'list' ]);
			$router->get('/prepare/@item2_id', [ DemandsController::class, 'prepare' ]);
			$router->post('/demand', [ DemandsController::class, 'demand' ]);
			$router->get('/accept/@id', [ DemandsController::class, 'accept' ]);
			$router->get('/deny/@id', [ DemandsController::class, 'deny' ]);
		});

		// itemPhotos
		$router->group('/itemPhotos', function() use ($router, $app) {
			$router->post('/save', [ ItemPhotosController::class, 'save' ]);
			$router->get('/showForm/@id', [ ItemPhotosController::class, 'showForm' ]);
			$router->get('/delete/@id', [ ItemPhotosController::class, 'delete' ]);
		});
	});

}, [ SecurityHeadersMiddleware::class ]);