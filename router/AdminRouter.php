<?php

namespace project\Routers;

use project\Controllers\AdminController;

include __DIR__ . '/../Controller/AdminController.php';

class AdminRouter
{
    private array $routes = [
        'GET:/' => [AdminController::class, 'showFileManager'],
        'GET:/list' => [AdminController::class, 'showFileManager'],
        'POST:/upload' => [AdminController::class, 'uploadFile'],
        'GET:/delete-file' => [AdminController::class, 'deleteFile'],
        'POST:/create-dir' => [AdminController::class, 'createDirectory'],
        'GET:/delete-dir' => [AdminController::class, 'deleteDirectory'],
    ];

    public function route(string $requestMethod, string $requestUri): void
    {
        $routeKey = $requestMethod . ':' . $requestUri;

        foreach ($this->routes as $pattern => [$controllerClass, $method]) {
            if ($this->matchRoute($routeKey, $pattern)) {
                $controllerInstance = new $controllerClass();
                $controllerInstance->$method();
                return;
            }
        }

        http_response_code(404);
        die("Admin route not found: {$requestMethod} {$requestUri}");
    }

    private function matchRoute(string $routeKey, string $pattern): bool
    {
        return $routeKey === $pattern;
    }
}