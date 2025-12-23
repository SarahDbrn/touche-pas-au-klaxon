<?php
declare(strict_types=1);

class AuthController extends Controller
{
    public function login(): void
    {
        // 1 Vérifier que le formulaire est soumis en POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirectTo('/login');
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
            'id'    => $user['id'],
            'email' => $user['email'],
        ];

        // 6 REDIRECTION INTELLIGENTE
        $redirect = $_POST['redirect'] ?? '/dashboard';

        // sécurité minimale (URL interne uniquement)
        if (!is_string($redirect) || $redirect === '' || $redirect[0] !== '/') {
            $redirect = '/dashboard';
        }

        redirectTo($redirect);
    }
}
