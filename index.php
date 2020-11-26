<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . 'vendor/autoload.php';

// instance de la base de données
$db = new DB();

// ajout des informations pour se connecter à la base de données
$ini_file = parse_ini_file('src/conf/conf.ini');
$db->addConnection([
    'driver'    => $ini_file['driver'],
    'host'      => $ini_file['host'],
    'database'  => $ini_file['database'],
    'username'  => $ini_file['username'],
    'password'  => $ini_file['password'],
    'prefix'    => ''
]);

$db->setAsGlobal();
$db->bootEloquent();

// Creation du route slim
$app = AppFactory::create();
$app->addRoutingMiddleware();

// gestion des erreurs
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// creation d'un chemin
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello, world");
    return $response;
});

// demarais le routeur
$app->run();

//require('controller.php');
//
//if (isset($_GET['action'])) {
//  if ($_GET['action'] == 'listRecipes' && isset($_GET['level'])) {
//    recipiesHierarchy();
//  }
//}else {
//  index();
//}
