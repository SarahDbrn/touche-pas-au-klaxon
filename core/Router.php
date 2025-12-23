<?php
declare(strict_types=1);

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = require CONFIG_PATH . '/routes.php';
    }

    public function dispatch(string $url): void
    {
        $path = $this->normalize($url);

        if (!isset($this->routes[$path])) {
            http_response_code(404);
            echo "404 - Page not found";
            return;
        }

        [$controllerName, $method] = $this->routes[$path];

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Controller not found: " . htmlspecialchars($controllerName);
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            http_response_code(500);
            echo "Method not found: " . htmlspecialchars($method);
            return;
        }

        $controller->$method();
    }

    private function normalize(string $url): string
    {
        $url = parse_url($url, PHP_URL_PATH) ?? '/';
        $url = rtrim($url, '/');
        return $url === '' ? '/' : $url;
    }
}
