<?php
use app\controllers\ItemController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router
 * @var Engine $app
 */

use app\controllers\ExchangeController;

$router->group('', function(Router $router) use ($app) {

    $router->get('/', function() use ($app) {
        $app->render('home/index');
    });

}, [ SecurityHeadersMiddleware::class ]);

$router->get('/ui/items/@id', function($id) use ($app) {
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
            echo "<p style='color:green;'>Demande d'échange envoyée !</p>";
        } else {
            echo "<p style='color:red;'>Erreur lors de l'envoi de la demande.</p>";
        }
    } else {
        echo "<p style='color:red;'>Veuillez sélectionner un objet.</p>";
    }
});

// Page pour gérer les échanges
$router->get('/exchange/manage', function() use ($app) {
    if(session_status() === PHP_SESSION_NONE) session_start();

    $controller = new \app\controllers\ExchangeController($app);
    $controller->manage();
});

// Route pour accepter ou refuser un échange
$router->post('/exchange/respond', function() use ($app) {
    if(session_status() === PHP_SESSION_NONE) session_start();

    $controller = new \app\controllers\ExchangeController($app);
    $controller->respond();
});


$router->get('/exchange/manage', function() use ($app) {
    $controller = new ExchangeController($app);
    $controller->manage();
});

$router->get('/exchange/accept/@id', function($id) use ($app) {
    $controller = new ExchangeController($app);
    $controller->accept($id);
});

$router->get('/exchange/reject/@id', function($id) use ($app) {
    $controller = new ExchangeController($app);
    $controller->reject($id);
});

