<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Auth.php';

/**
 * Chemin racine du projet (ex: .../touche-pas-au-klaxon)
 * Utilisé par l'autoloader.
 */
$baseDir = dirname(__DIR__);

spl_autoload_register(function (string $class) use ($baseDir): void {
    $paths = [
        $baseDir . '/app/Controllers/',
        $baseDir . '/app/Models/',
        $baseDir . '/core/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// base ex: /touche-pas-au-klaxon/public
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($baseUrl !== '' && $baseUrl !== '/' && strpos($path, $baseUrl) === 0) {
    $path = substr($path, strlen($baseUrl));
}

$path = $path === '' ? '/' : $path;

if ($path === '/index.php') {
    $path = '/';
}

$router = new Router();
$router->dispatch($path, $_SERVER['REQUEST_METHOD']);
