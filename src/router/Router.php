<?php

declare(strict_types=1);

namespace Router;

use Controller\GameController;
use Controller\AdminController;

include __DIR__ . '/../Controller/GameController.php';

include __DIR__ . '/../Controller/AdminController.php';
class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [
            '/admin' => [AdminController::class, 'index'],
            '/admin/action' => [AdminController::class, 'handleAction'],
            '/test-auth' => [AdminController::class, 'testAuth'],
            '/' => [GameController::class, 'showGames'],
        ];
    }

    public function handleRequest(): void
    {
        $uri = $this->getCurrentUri();
        error_log("Trying to route: " . $uri);
        error_log("Available routes: " . print_r(array_keys($this->routes), true));
        $uri = $this->getCurrentUri();
        if (isset($this->routes[$uri])) {
            [$controllerClass, $method] = $this->routes[$uri];
            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Controller class {$controllerClass} not found");
            }
            $controller = new $controllerClass();
            $controller->$method();
        }
    }

    private function getCurrentUri(): string
    {
        $uri = rawurldecode($_SERVER['REQUEST_URI'] ?? '/');
        $uri = parse_url($uri, PHP_URL_PATH);

        // Удаляем повторяющиеся слэши
        $uri = preg_replace('#/+#', '/', $uri);

        // Нормализуем URI
        $uri = rtrim($uri, '/') ?: '/';

        error_log("Final URI: {$uri}");
        return $uri;
    }
}