<?php

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
include __DIR__ . '/Router/myrouter.php';

use Router\MyRouter;
use Controller\GameController;
$router = new MyRouter();
$router->addRoute('/', [GameController::class, 'showGames']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->handleRequest($uri);
