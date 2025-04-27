<?php
declare(strict_types=1);

namespace MyGameSite\Router;

use MyGameSite\Controller\AdminController;
use MyGameSite\Controller\GameController;
use MyGameSite\Services\TemplateEngine;

class Router
{
    private array $routes;
    private TemplateEngine $templateEngine;

    public function __construct()
    {
        $this->templateEngine = new TemplateEngine(
            __DIR__ . '/../../template',
            __DIR__ . '/../../public/assets'
        );

        $this->routes = [
            '/admin' => [AdminController::class, 'index'],
            '/admin/files' => [AdminController::class, 'handleAction'],
            '/admin/logout' => [AdminController::class, 'testAuth'],
            '/' => [GameController::class, 'showGames'],
        ];
    }

    public function handleRequest(): void
    {
        $uri = $this->getCurrentUri();

        if (isset($this->routes[$uri])) {
            [$controllerClass, $method] = $this->routes[$uri];

            $controller = new $controllerClass($this->templateEngine);
            $controller->$method();
        } else {
            http_response_code(404);
            echo $this->templateEngine->render('errors/404');
        }
    }

    private function getCurrentUri(): string
    {
        $uri = rawurldecode($_SERVER['REQUEST_URI'] ?? '/');
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = preg_replace('#/+#', '/', $uri);
        return rtrim($uri, '/') ?: '/';
    }

}