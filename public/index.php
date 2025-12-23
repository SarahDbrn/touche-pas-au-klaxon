<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();
$router->dispatch($_GET['url'] ?? '/');
