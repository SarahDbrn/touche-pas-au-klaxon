<?php
declare(strict_types=1);

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = require CONFIG_PATH . '/routes.php';
    }

    public function dispatch(string $url, string $httpMethod): void
    {
        $path = $this->normalize($url);
        $method = strtoupper($httpMethod);

        $key = $method . ' ' . $path;

        if (!isset($this->routes[$key])) {
            http_response_code(404);
            echo "404 - Page not found";
            return;
        }

        [$controllerName, $action] = $this->routes[$key];

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Controller not found: " . htmlspecialchars($controllerName);
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(500);
            echo "Method not found: " . htmlspecialchars($action);
            return;
        }

        $controller->$action();
    }

    private function normalize(string $url): string
    {
        $url = parse_url($url, PHP_URL_PATH) ?? '/';
        $url = rtrim($url, '/');
        return $url === '' ? '/' : $url;
    }
}
