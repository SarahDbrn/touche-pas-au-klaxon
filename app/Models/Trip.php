<?php
declare(strict_types=1);

/**
 * Modèle Trip
 * Gestion des trajets (lecture / écriture)
 */
final class Trip
{
    /**
     * Trouve un trajet par son ID
     *
     * @return array<string,mixed>|null
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT * FROM trips WHERE id = :id";
        $stmt = Database::query($sql, ['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Met à jour un trajet
     * @param array<string,mixed> $data
     */
    public static function update(int $id, array $data): void
    {
        $sql = "
            UPDATE trips SET
                departure_at = :departure_at,
                arrival_at = :arrival_at,
                total_seats = :total_seats,
                available_seats = :available_seats,
                departure_agency_id = :departure_agency_id,
                arrival_agency_id = :arrival_agency_id,
                contact_id = :contact_id
            WHERE id = :id
        ";

        Database::query($sql, [
            'id' => $id,
            'departure_at' => $data['departure_at'],
            'arrival_at' => $data['arrival_at'],
            'total_seats' => $data['total_seats'],
            'available_seats' => $data['available_seats'],
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id' => $data['arrival_agency_id'],
            'contact_id' => $data['contact_id'],
        ]);
    }

    /**
     * Supprime un trajet
     */
    public static function delete(int $id): void
    {
        Database::query("DELETE FROM trips WHERE id = :id", ['id' => $id]);
    }

    /**
     * Récupère les trajets à venir avec des places disponibles
     *
     * @return array<int, array<string,mixed>>
     */
    public static function getUpcomingAvailableTrips(): array
    {
        $sql = "
            SELECT
                t.id,
                t.author_id,
                t.departure_at,
                t.arrival_at,
                t.total_seats,
                t.available_seats,

                da.name AS departure_agency,
                aa.name AS arrival_agency,

                u.firstname AS contact_firstname,
                u.lastname  AS contact_lastname,
                u.email     AS contact_email,
                u.phone     AS contact_phone

            FROM trips t
            INNER JOIN agencies da ON da.id = t.departure_agency_id
            INNER JOIN agencies aa ON aa.id = t.arrival_agency_id
            INNER JOIN users u ON u.id = t.contact_id

            WHERE
                t.departure_at > NOW()
                AND t.available_seats > 0

            ORDER BY t.departure_at ASC
        ";

        $stmt = Database::query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Crée un trajet
     * @param array<string,mixed> $data
     * @return int id du trajet créé
     */
    public static function create(array $data): int
    {
        $sql = "
            INSERT INTO trips (
                departure_at, arrival_at,
                total_seats, available_seats,
                author_id, contact_id,
                departure_agency_id, arrival_agency_id
            ) VALUES (
                :departure_at, :arrival_at,
                :total_seats, :available_seats,
                :author_id, :contact_id,
                :departure_agency_id, :arrival_agency_id
            )
        ";

        Database::query($sql, [
            'departure_at' => $data['departure_at'],
            'arrival_at' => $data['arrival_at'],
            'total_seats' => $data['total_seats'],
            'available_seats' => $data['available_seats'],
            'author_id' => $data['author_id'],
            'contact_id' => $data['contact_id'],
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id' => $data['arrival_agency_id'],
        ]);

        return (int)Database::getConnection()->lastInsertId();
    }

    public static function allWithAgenciesAndAuthor(): array
    {
        $pdo = Database::getConnection();
        $sql = "
            SELECT
                t.id,
                t.departure_at, t.arrival_at,
                t.total_seats, t.available_seats,
                a1.name AS departure_agency,
                a2.name AS arrival_agency,
                u.firstname AS author_firstname,
                u.lastname AS author_lastname,
                u.email AS author_email
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            JOIN users u ON u.id = t.author_id
            ORDER BY t.departure_at ASC
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll() ?: [];
    }


    public static function deleteById(int $id): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM trips WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

}
