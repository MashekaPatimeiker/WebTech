<?php

namespace Router;

class MyRouter {
    private $routes = [];

    public function addRoute($uri, $action) {
        $this->routes[$uri] = $action;
    }

    public function handleRequest($uri) {
        if (isset($this->routes[$uri])) {
            [$controller, $method] = $this->routes[$uri];
            (new $controller())->$method();
        } else {
            http_response_code(404);
            echo "404 Не найдено";
        }
    }
}
