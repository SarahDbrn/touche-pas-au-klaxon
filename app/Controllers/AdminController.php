<?php
declare(strict_types=1);

class AdminController extends Controller
{
    public function dashboard(): void
    {
        Auth::requireAdmin();

        $this->render('admin/dashboard', [
            'title' => 'Tableau de bord',
        ]);
    }

    public function users(): void
    {
        Auth::requireAdmin();

        $users = User::all(); // à créer dans User.php

        $this->render('admin/users', [
            'title' => 'Utilisateurs',
            'users' => $users,
        ]);
    }

    public function agencies(): void
    {
        Auth::requireAdmin();

        $agencies = Agency::all(); // à créer dans Agency.php

        $this->render('admin/agencies/index', [
            'title' => 'Agences',
            'agencies' => $agencies,
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function createAgency(): void
    {
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/agencies');
            exit;
        }

        Auth::verifyCsrfToken($_POST['csrf'] ?? '');

        $name = trim((string)($_POST['name'] ?? ''));
        $errors = [];

        if ($name === '') {
            $errors[] = "Le nom de l'agence est requis.";
        } elseif (mb_strlen($name) > 100) {
            $errors[] = "Le nom est trop long (100 caractères max).";
        } elseif (Agency::existsByName($name)) {
            $errors[] = "Cette agence existe déjà.";
        }

        if (!empty($errors)) {
            // flash error + retour
            $_SESSION['flash'] = ['type' => 'danger', 'message' => implode(' ', $errors)];
            header('Location: ' . BASE_URL . '/admin/agencies');
            exit;
        }

        Agency::create($name);

        $_SESSION['flash'] = ['type' => 'success', 'message' => "Agence créée."];
        header('Location: ' . BASE_URL . '/admin/agencies');
        exit;
    }

    public function editAgency(): void
    {
        Auth::requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/agencies');
            exit;
        }

        $agency = Agency::find($id);
        if (!$agency) {
            http_response_code(404);
            echo "Agence introuvable.";
            exit;
        }

        $this->render('admin/agencies/edit', [
            'title' => 'Modifier une agence',
            'agency' => $agency,
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function updateAgency(): void
    {
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/agencies');
            exit;
        }

        Auth::verifyCsrfToken($_POST['csrf'] ?? '');

        $id = (int)($_POST['id'] ?? 0);
        $name = trim((string)($_POST['name'] ?? ''));

        if ($id <= 0 || $name === '') {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => "Données invalides."];
            header('Location: ' . BASE_URL . '/admin/agencies');
            exit;
        }

        if (Agency::existsByNameExceptId($name, $id)) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => "Une autre agence porte déjà ce nom."];
            header('Location: ' . BASE_URL . '/admin/agencies/edit?id=' . $id);
            exit;
        }

        Agency::update($id, $name);

        $_SESSION['flash'] = ['type' => 'success', 'message' => "Agence modifiée."];
        header('Location: ' . BASE_URL . '/admin/agencies');
        exit;
    }

    public function deleteAgency(): void
    {
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/agencies');
            exit;
        }

        Auth::verifyCsrfToken($_POST['csrf'] ?? '');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/agencies');
            exit;
        }

        try {
            Agency::delete($id);
            $_SESSION['flash'] = ['type' => 'success', 'message' => "Agence supprimée."];
        } catch (Throwable $e) {
            // typiquement FK si utilisée dans des trajets
            $_SESSION['flash'] = ['type' => 'danger', 'message' => "Suppression impossible (agence utilisée dans des trajets)."];
        }

        header('Location: ' . BASE_URL . '/admin/agencies');
        exit;
    }

    public function trips(): void
    {
        Auth::requireAdmin();

        $trips = Trip::allWithAgenciesAndAuthor(); // à créer dans Trip.php

        $this->render('admin/trips', [
            'title' => 'Trajets',
            'trips' => $trips,
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function deleteTrip(): void
    {
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/trips');
            exit;
        }

        Auth::verifyCsrfToken($_POST['csrf'] ?? '');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/trips');
            exit;
        }

        Trip::deleteById($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => "Trajet supprimé."];
        header('Location: ' . BASE_URL . '/admin/trips');
        exit;
    }
}
