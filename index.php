<?php
require __DIR__ . '/autoload.php';
require_once __DIR__ . '/src/router/Router.php';

use Router\Router;

$router = new Router();
$router->handleRequest();