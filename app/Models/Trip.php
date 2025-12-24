<?php
declare(strict_types=1);

/**
 * Modèle Trip
 * Gestion des trajets (lecture / écriture)
 */
final class Trip
{
    /**
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
}
