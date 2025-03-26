<?php

require_once __DIR__ . '/../../app/controllers/GameController.php';

use Controller\GameController;

$routes = [
    '/' => [GameController::class, 'showGames']
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/index.php', '', $uri);

if (isset($routes[$uri])) {
    [$controller, $method] = $routes[$uri];
    (new $controller())->$method();
}

