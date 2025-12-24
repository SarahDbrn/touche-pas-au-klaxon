<?php
declare(strict_types=1);

final class Database
{
    private static ?PDO $pdo = null;

    /**
     * Retourne une connexion PDO unique (singleton).
     * @throws RuntimeException si la connexion échoue.
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        // On suppose que config/config.php définit DB_HOST, DB_NAME, DB_USER, DB_PASS
        $configFile = dirname(__DIR__) . '/config/config.php';
        if (!file_exists($configFile)) {
            throw new RuntimeException('Fichier de config introuvable : ' . $configFile);
        }
        require_once $configFile;

        foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'] as $key) {
            if (!defined($key)) {
                throw new RuntimeException("Constante de config manquante : {$key}");
            }
        }

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        try {
            self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // En prod on logge, et on évite d’afficher des détails sensibles
            throw new RuntimeException('Erreur de connexion à la base de données.');
        }

        return self::$pdo;
    }

    /**
     * Exécute une requête préparée et retourne le statement.
     * @param array<string, mixed> $params
     */
    public static function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Empêche instanciation
    private function __construct() {}
    private function __clone() {}
}
