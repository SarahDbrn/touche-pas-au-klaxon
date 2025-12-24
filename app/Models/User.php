<?php
declare(strict_types=1);

class User
{
    public static function findByEmail(string $email): ?array
    {
        $sql = "
            SELECT
                id,
                firstname,
                lastname,
                email,
                phone,
                password,
                role
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = Database::query($sql, ['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }
}
