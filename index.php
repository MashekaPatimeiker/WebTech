<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/vendor/autoload.php';

use MyGameSite\Router\Router;

$router = new Router();
$router->handleRequest();