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

$router->post('/exchange/propose', function() use ($app) {
    if(session_status() === PHP_SESSION_NONE) session_start();

    $item1_id = $_POST['item1_id'] ?? null;
    $item2_id = $_POST['item2_id'] ?? null;

    if($item1_id && $item2_id){
        $repo = new \app\repositories\PeoplesItemsRepository($app->db());
        $success = $repo->proposeExchange($item1_id, $item2_id);

        if($success){
            echo "Demande d'échange envoyée !";
        } else {
            echo "Erreur lors de l'envoi de la demande.";
        }
    } else {
        echo "Veuillez sélectionner un objet.";
    }
});