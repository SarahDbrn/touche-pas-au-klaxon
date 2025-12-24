<?php
declare(strict_types=1);

/**
 * Modèle Trip
 * Gestion des trajets (lecture / écriture)
 */
final class Trip
{
    /**
     * Récupère les trajets à venir avec des places disponibles
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getUpcomingAvailableTrips(): array
    {
        $sql = "
            SELECT
                t.id,
                t.departure_at,
                t.arrival_at,
                t.total_seats,
                t.available_seats,

                da.name AS departure_agency,
                aa.name AS arrival_agency

            FROM trips t
            INNER JOIN agencies da ON da.id = t.departure_agency_id
            INNER JOIN agencies aa ON aa.id = t.arrival_agency_id

            WHERE
                t.departure_at > NOW()
                AND t.available_seats > 0

            ORDER BY t.departure_at ASC
        ";

        $stmt = Database::query($sql);
        return $stmt->fetchAll();
    }
}
