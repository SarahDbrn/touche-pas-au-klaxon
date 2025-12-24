<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    $version = $pdo->query('SELECT VERSION() AS v')->fetch();
    echo "OK DB, version = " . $version['v'] . PHP_EOL;
} catch (Throwable $e) {
    echo "KO: " . $e->getMessage() . PHP_EOL;
}
