<?php
require '../helpers.php';
require basePath('Database.php');
require basePath('Router.php');

// Initialize the Router
$router = new Router();

// Require the routes
$routes = require basePath('routes.php');

// Get the URI and the method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route the request
$router->route($uri, $method, $routes);
