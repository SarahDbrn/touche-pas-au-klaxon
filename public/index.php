<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// base ex: /touche-pas-au-klaxon/public
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($base !== '' && $base !== '/' && strpos($path, $base) === 0) {
    $path = substr($path, strlen($base));
}

$path = $path === '' ? '/' : $path;

// Cas où on appelle directement /public/index.php
if ($path === '/index.php') {
    $path = '/';
}

$router = new Router();
$router->dispatch($path);
