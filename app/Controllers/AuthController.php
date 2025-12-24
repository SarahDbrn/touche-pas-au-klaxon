<?php
declare(strict_types=1);

class AuthController extends Controller
{
    // LOGIN
    public function login(): void
    {
        // 1.1 GET : afficher le formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // optionnel mais propre : si déjà connecté, on évite de revoir login
        // requireGuest('/dashboard');

        $this->render('auth/login', [
            'title' => 'Connexion',
            'errors' => [],
        ]);
        return;
    }

    // 1.2 POST : traiter le formulaire
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo "Method not allowed";
        return;
    }

        // 2 Récupération des champs
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // 3 Vérifications basiques
        if ($email === '' || $password === '') {
            $this->render('auth/login', [
                'title' => 'Connexion',
                'errors' => ['Champs manquants'],
            ]);
            return;
        }

        // 4 Authentification
        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->render('auth/login', [
                'title' => 'Connexion',
                'errors' => ['Identifiants incorrects'],
            ]);
            return;
        }

        // 5 LOGIN RÉUSSI → mise en session
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'firstname' => (string)($user['firstname'] ?? ''),
            'lastname' => (string)($user['lastname'] ?? ''),
            'email' => (string)($user['email'] ?? ''),
            'phone' => (string)($user['phone'] ?? ''),
            'role' => (string)($user['role'] ?? 'USER'),
        ];


        // 6 REDIRECTION INTELLIGENTE
        $redirect = $_POST['redirect'] ?? '/dashboard';

        // sécurité minimale (URL interne uniquement)
        if (!is_string($redirect) || $redirect === '' || $redirect[0] !== '/') {
            $redirect = '/dashboard';
        }

        redirectTo($redirect);
    }
    // LOGOUT
    public function logout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirectTo('/');
        }

        if (!verifyCsrfToken($_POST['csrf'] ?? null)) {
            http_response_code(403);
            echo "CSRF token invalide";
            exit;
        }

        // Destruction propre de la session
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        redirectTo('/');
    }

}
