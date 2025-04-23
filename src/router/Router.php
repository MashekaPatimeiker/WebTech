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
        try {
            $uri = $this->getCurrentUri();

            if (isset($this->routes[$uri])) {
                [$controllerClass, $method] = $this->routes[$uri];

                if (!class_exists($controllerClass)) {
                    throw new \RuntimeException("Controller class {$controllerClass} not found");
                }

                $controller = new $controllerClass();
                $controller->$method();
            } else {
                $this->notFoundResponse($uri);
            }
        } catch (\Throwable $e) {
            $this->errorResponse($e);
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
    private function normalizePath(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        return rtrim($path, '/') ?: '/';
    }

    private function notFoundResponse(string $uri): void
    {
        header("HTTP/1.0 404 Not Found");
        echo "404 Page Not Found. URI: " . htmlspecialchars($uri, ENT_QUOTES, 'UTF-8');
        exit;
    }

    private function errorResponse(\Throwable $e): void
    {
        error_log('Router error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        header("HTTP/1.1 500 Internal Server Error");
        echo "500 Internal Server Error";
        if (ini_get('display_errors')) {
            echo ": " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
        exit;
    }
}