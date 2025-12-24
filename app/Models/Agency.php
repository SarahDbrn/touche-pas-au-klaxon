<?php
declare(strict_types=1);

final class Agency
{
    public static function all(): array
    {
        $stmt = Database::query('SELECT id, name FROM agencies ORDER BY name ASC');
        return $stmt->fetchAll();
    }
}
