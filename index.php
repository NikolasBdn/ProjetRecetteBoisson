<?php

use boisson\controllers\ApiController;
use boisson\controllers\IngredientController;
use boisson\controllers\RecipeController;
use boisson\controllers\CartController;
use boisson\controllers\SearchController;
use boisson\controllers\UserController;
use boisson\utils\AppContainer;
use boisson\views\UserView;
use boisson\views\ViewRendering;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Illuminate\Database\Capsule\Manager as DB;
use Slim\Routing\RouteContext;

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

// démarrage d'une session
session_start();

// Creation du route slim
$app = AppContainer::getInstance();
$app->addRoutingMiddleware();

// gestion des erreurs
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Root
$app->get('/', function (Request $request, Response $response, $args) {
    //$response->getBody()->write((new ViewRendering())->render("Hello, world!" . $_COOKIE['cart'], "Home page")); // le cookie n'est pas instancié et ça fait crash l'app...
    $response->getBody()->write((new ViewRendering())->render("Hello, world!", "Home page"));
    return $response;
})->setName('root');

// Ingredient List
$app->get('/ingredient', function (Request $request, Response $response, $args) {
    $response->getBody()->write(IngredientController::ingredients());
    return $response;
})->setName('ingredient_list');

// Ingredient item
$app->get('/ingredient/{id:[0-9]+}', function (Request $request, Response $response, $args) {
    // id = $args['id']
    $response->getBody()->write(IngredientController::ingredient($args['id']));
    return $response;
})->setName('ingredient');

// Recipe List
$app->get('/recipe', function (Request $request, Response $response, $args) {
    $response->getBody()->write(RecipeController::recipeList());
    return $response;
})->setName('recipe_list');

// Recipe Item
$app->get('/recipe/{id:[0-9]+}', function (Request $request, Response $response, $args) {
    $response->getBody()->write(RecipeController::recipe($args['id']));
    return $response;
})->setName('recipe');

// Cart List
$app->get('/cart', function (Request $request, Response $response, $args) {
    $response->getBody()->write(CartController::cart());
    return $response;
})->setName('cart');

// Add recipe to Cart
$app->get('/cart/add/{id:[0-9]+}', function (Request $request, Response $response, $args) {
    $app = AppContainer::getInstance();
    CartController::add($args['id']);
    $routeParser = RouteContext::fromRequest($request)->getRouteParser();
    $url = $routeParser->urlFor('recipe', array('id' => $args['id']));
    return $app->getresponseFactory()->createResponse()->withHeader('Location', $url)->withStatus(302);
})->setName('cart_add_recipe');

// Delete recipe to Cart
$app->get('/cart/delete/{id:[0-9]+}', function (Request $request, Response $response, $args) {
    $app = AppContainer::getInstance();
    CartController::delete($args['id']);
    $routeParser = RouteContext::fromRequest($request)->getRouteParser();
    $url = $routeParser->urlFor('recipe', array('id' => $args['id']));
    return $app->getresponseFactory()->createResponse()->withHeader('Location', $url)->withStatus(302);
})->setName('cart_add_recipe');

// Search page
$app->post('/search', function (Request $request, Response $response, $args) {
    $response->getBody()->write(SearchController::search($_POST['search_bar']));
    return $response;
})->setName('search');

// user
$app->get('/login', function (Request $request, Response $response, $args) {
    $response->getBody()->write(UserView::accountRegisterAndLogin());
    return $response;
})->setName('login_page');

$app->get('/login/off', function (Request $request, Response $response, $args) {
    UserController::logout();
    return $response;
})->setName('login_off');

$app->post('/register', function (Request $request, Response $response, $args) {
    $response->getBody()->write(UserController::registerPost());
    return $response;
})->setName('register');

$app->post('/login', function (Request $request, Response $response, $args) {
    $response->getBody()->write(UserController::loginPost());
    return $response;
})->setName('login');

// Rest api use for search bar

// search all data that match string
$app->get('/api/search/{string}', function (Request $request, Response $response, $args) {
    $response->getBody()->write(ApiController::searchFor($args['string']));
    return $response->withHeader('Content-Type', 'application/json');
})->setName('api_search');

// search all data that match string with applying filter
// filter type: [recipe/ingredient]
$app->get('/api/search/{string}/filter/{filter}', function (Request $request, Response $response, $args) {
    $response->getBody()->write(ApiController::searchForFilteredBy($args['string'], $args['filter']));
    return $response->withHeader('Content-Type', 'application/json');
})->setName('api_search_filter');

// search 6 result that match string
$app->get('/api/quick_search/{string}', function (Request $request, Response $response, $args) {
    $response->getBody()->write(ApiController::quickSearch($args['string']));
    return $response->withHeader('Content-Type', 'application/json');
})->setName('api_quick_search');


// start router
$app->run();
