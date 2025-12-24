<?php
declare(strict_types=1);

class TripController extends Controller
{
    public function edit(): void
    {
        requireLogin();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            http_response_code(400);
            echo "Bad request";
            return;
        }

        $trip = Trip::findById($id);
        if (!$trip) {
            http_response_code(404);
            echo "Trip not found";
            return;
        }

        $userId = currentUserId();
        if (!$userId || (!isAdmin() && (int)$trip['author_id'] !== $userId)) {
            http_response_code(403);
            echo "Forbidden";
            return;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
                $errors[] = "CSRF invalide.";
            }

            $departureAgencyId = (int)($_POST['departure_agency_id'] ?? 0);
            $arrivalAgencyId   = (int)($_POST['arrival_agency_id'] ?? 0);
            $departureAt       = trim((string)($_POST['departure_at'] ?? ''));
            $arrivalAt         = trim((string)($_POST['arrival_at'] ?? ''));
            $totalSeats        = (int)($_POST['total_seats'] ?? 0);
            $availableSeats    = (int)($_POST['available_seats'] ?? 0);

            $departureAtSql = $departureAt !== '' ? str_replace('T', ' ', $departureAt) . ':00' : '';
            $arrivalAtSql   = $arrivalAt !== '' ? str_replace('T', ' ', $arrivalAt) . ':00' : '';

            if ($departureAgencyId <= 0 || $arrivalAgencyId <= 0) $errors[] = "Agences invalides.";
            if ($departureAgencyId === $arrivalAgencyId) $errors[] = "Départ et arrivée doivent être différents.";
            if ($departureAtSql === '' || $arrivalAtSql === '') $errors[] = "Dates obligatoires.";
            if ($departureAtSql !== '' && $arrivalAtSql !== '' && strtotime($arrivalAtSql) <= strtotime($departureAtSql)) {
                $errors[] = "On ne peut pas arriver avant de partir.";
            }
            if ($totalSeats <= 0) $errors[] = "Le nombre total de places doit être > 0.";
            if ($availableSeats < 0) $errors[] = "Le nombre de places disponibles doit être ≥ 0.";
            if ($availableSeats > $totalSeats) $errors[] = "Places disponibles ≤ places totales.";

            if (empty($errors)) {
                Trip::update($id, [
                    'departure_at' => $departureAtSql,
                    'arrival_at' => $arrivalAtSql,
                    'total_seats' => $totalSeats,
                    'available_seats' => $availableSeats,
                    'departure_agency_id' => $departureAgencyId,
                    'arrival_agency_id' => $arrivalAgencyId,
                    'contact_id' => (int)$trip['contact_id'],
                ]);

                $_SESSION['flash_success'] = "Trajet modifié avec succès.";
                redirectTo('/');
            }

            $trip = array_merge($trip, [
                'departure_agency_id' => $departureAgencyId,
                'arrival_agency_id' => $arrivalAgencyId,
                'departure_at' => $departureAtSql,
                'arrival_at' => $arrivalAtSql,
                'total_seats' => $totalSeats,
                'available_seats' => $availableSeats,
            ]);
        }

        $agencies = Agency::all();

        $this->render('trips/edit', [
            'title' => 'Modifier un trajet',
            'trip' => $trip,
            'agencies' => $agencies,
            'errors' => $errors,
        ]);
    }

    public function delete(): void
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method Not Allowed";
            return;
        }

        if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            echo "CSRF invalide";
            return;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            http_response_code(400);
            echo "Bad request";
            return;
        }

        $trip = Trip::findById($id);
        if (!$trip) {
            http_response_code(404);
            echo "Trip not found";
            return;
        }

        $userId = currentUserId();
        if (!$userId || (!isAdmin() && (int)$trip['author_id'] !== $userId)) {
            http_response_code(403);
            echo "Forbidden";
            return;
        }

        Trip::delete($id);
        $_SESSION['flash_success'] = "Trajet supprimé avec succès.";
        redirectTo('/');
    }

    public function create(): void
    {
        requireLogin();

        $user = currentUser();
        if (!$user) {
            redirectTo('/login');
        }

        $agencies = Agency::all();
        $errors = [];

        $form = [
            'departure_agency_id' => '',
            'arrival_agency_id' => '',
            'departure_at' => '',
            'arrival_at' => '',
            'total_seats' => 1,
            'available_seats' => 1,
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
                $errors[] = "CSRF invalide.";
            }

            $departureAgencyId = (int)($_POST['departure_agency_id'] ?? 0);
            $arrivalAgencyId   = (int)($_POST['arrival_agency_id'] ?? 0);
            $departureAt       = trim((string)($_POST['departure_at'] ?? ''));
            $arrivalAt         = trim((string)($_POST['arrival_at'] ?? ''));
            $totalSeats        = (int)($_POST['total_seats'] ?? 0);
            $availableSeats    = (int)($_POST['available_seats'] ?? 0);

            $departureAtSql = $departureAt !== '' ? str_replace('T', ' ', $departureAt) . ':00' : '';
            $arrivalAtSql   = $arrivalAt !== '' ? str_replace('T', ' ', $arrivalAt) . ':00' : '';

            if ($departureAgencyId <= 0 || $arrivalAgencyId <= 0) $errors[] = "Agences invalides.";
            if ($departureAgencyId === $arrivalAgencyId) $errors[] = "L’agence de départ et l’agence d’arrivée doivent être différentes.";
            if ($departureAtSql === '' || $arrivalAtSql === '') $errors[] = "Dates obligatoires.";
            if ($departureAtSql !== '' && $arrivalAtSql !== '' && strtotime($arrivalAtSql) <= strtotime($departureAtSql)) {
                $errors[] = "On ne peut pas arriver avant de partir.";
            }
            if ($totalSeats <= 0) $errors[] = "Le nombre total de places doit être > 0.";
            if ($availableSeats < 0) $errors[] = "Le nombre de places disponibles doit être ≥ 0.";
            if ($availableSeats > $totalSeats) $errors[] = "Les places disponibles doivent être ≤ aux places totales.";

            $form = [
                'departure_agency_id' => $departureAgencyId,
                'arrival_agency_id' => $arrivalAgencyId,
                'departure_at' => $departureAt,
                'arrival_at' => $arrivalAt,
                'total_seats' => $totalSeats,
                'available_seats' => $availableSeats,
            ];

            if (empty($errors)) {
                Trip::create([
                    'departure_at' => $departureAtSql,
                    'arrival_at' => $arrivalAtSql,
                    'total_seats' => $totalSeats,
                    'available_seats' => $availableSeats,
                    'author_id' => (int)$user['id'],
                    'contact_id' => (int)$user['id'],
                    'departure_agency_id' => $departureAgencyId,
                    'arrival_agency_id' => $arrivalAgencyId,
                ]);

                $_SESSION['flash_success'] = "Trajet créé avec succès.";
                redirectTo('/');
            }
        }

        $this->render('trips/create', [
            'title' => 'Créer un trajet',
            'user' => $user,
            'agencies' => $agencies,
            'errors' => $errors,
            'form' => $form,
        ]);
    }
}
