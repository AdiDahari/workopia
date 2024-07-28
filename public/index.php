<?php
require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;

require "../helpers.php";
// spl_autoload_register(function ($class) {
//   $path = basePath("Framework/{$class}.php");

//   if (file_exists($path)) {
//     require $path;
//   }
// });

// Initializing router
$router = new Router();

// Including routes
$routes = require basePath('routes.php');

// Getting relevant request info
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Routing request
$router->route($uri, $method);
