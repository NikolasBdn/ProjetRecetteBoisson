<?php

use boisson\controllers\RecipeController;
use boisson\views\ViewRendering;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . '/vendor/autoload.php';

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

// Root
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write((new ViewRendering())->render("Hello, world!", "Home page"));
    return $response;
})->setName('root');

// TODO("faire les controleur et les vue correspondant")
// Ingredient list
$app->get('/ingredient', function (Request $request, Response $response, $args) {
    $response->getBody()->write("wip");
    return $response;
})->setName('ingredient_list');

// Ingredient item
$app->get('/ingredient/{id}', function (Request $request, Response $response, $args) {
    // id = $args['id']
    $response->getBody()->write("wip");
    return $response;
})->setName('ingredient');

// TODO("faire les controleur et les vue correspondant")
// Recipe
$app->get('/recipe/{id}', function (Request $request, Response $response, $args) {
    global $app;
    $response->getBody()->write(RecipeController::recipe($app , $args['id']));
    return $response;
})->setName('recipe');

// demarais le routeur
$app->run();
