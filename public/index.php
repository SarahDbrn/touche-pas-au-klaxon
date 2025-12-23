<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Auth.php';


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
$router->dispatch($path);
