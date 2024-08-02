<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;

require "../helpers.php";

// Initializing router
$router = new Router();

// Including routes
$routes = require basePath('routes.php');

// Getting relevant request info
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routing request
$router->route($uri);
