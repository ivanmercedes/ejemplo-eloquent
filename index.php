<?php

require_once 'vendor/autoload.php';

// Carga el fichero env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


// Muestra los errores cuando se esta en modo dev
// if ($_ENV['APP_MODE'] === "dev") {
//     ini_set('display_erros', 1);
//     ini_set('display_startup_errors', 1);
//     error_reporting(E_ALL);
// }


/**
 * Conexion de la base de datos
 */

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_NAME'],
    'username'  => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASS'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();


/**
 * Rutas
 */

$route = $_GET['route'] ?? '/';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
// 41755 
$router = new RouteCollector();


$router->controller('/', App\Controllers\HomeController::class);
$router->controller('/notes', App\Controllers\NoteController::class);
$router->controller('/users', App\Controllers\UserController::class);
$router->controller('/cases', App\Controllers\CaseController::class);
$router->controller('/messages', App\Controllers\MessageController::class);

$dispatcher =  new Dispatcher($router->getData());

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (HttpRouteNotFoundException $e) {

    exit;
} catch (HttpMethodNotAllowedException $e) {

    exit;
}

echo $response;
