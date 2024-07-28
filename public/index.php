<?php
require "../helpers.php";
require basePath('Router.php');
require basePath('Database.php');

// Initializing router
$router = new Router();

// Including routes
$routes = require basePath('routes.php');

// Getting relevant request info
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Routing request
$router->route($uri, $method);
