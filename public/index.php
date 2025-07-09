<?php


// TODO:
// 1. add different routes
// 2. ???


const BASE_PATH = __DIR__ . '/../';
const BASE_URI = '/proj-php/php-sql-exercise/php-with-routing-classes-oop/public/';

require_once BASE_PATH . 'app/services/utils.service.php';


spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require_once base_path("app/{$class}.php");
});

require_once base_path('app/bootstrap.php');


$router = new \Core\Router();
$routes = require_once base_path('app/routes.php');


$uri = remove_string_prefix(parse_url($_SERVER['REQUEST_URI'])['path'], BASE_URI) ?: '/';
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$router->route($uri, $method);
