<?php
declare(strict_types=1);

final class Agency
{
    /**
     * @return array<int, array<string, mixed>>
     */
public static function all(): array
{
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT id, name FROM agencies ORDER BY name");
    return $stmt->fetchAll() ?: [];
}

public static function find(int $id): ?array
{
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT id, name FROM agencies WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

public static function existsByName(string $name): bool
{
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT 1 FROM agencies WHERE name = :name LIMIT 1");
    $stmt->execute(['name' => $name]);
    return (bool)$stmt->fetchColumn();
}

public static function existsByNameExceptId(string $name, int $id): bool
{
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT 1 FROM agencies WHERE name = :name AND id <> :id LIMIT 1");
    $stmt->execute(['name' => $name, 'id' => $id]);
    return (bool)$stmt->fetchColumn();
}

public static function create(string $name): void
{
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("INSERT INTO agencies (name) VALUES (:name)");
    $stmt->execute(['name' => $name]);
}

public static function update(int $id, string $name): void
{
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("UPDATE agencies SET name = :name WHERE id = :id");
    $stmt->execute(['name' => $name, 'id' => $id]);
}

public static function delete(int $id): void
{
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("DELETE FROM agencies WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

}
