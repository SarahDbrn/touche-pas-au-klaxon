<?php
declare(strict_types=1);

class AuthController extends Controller
{
    public function login(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim((string)($_POST['email'] ?? ''));
            $password = (string)($_POST['password'] ?? '');

            // Validation
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide.";
            }
            if ($password === '' || strlen($password) < 8) {
                $errors[] = "Mot de passe invalide.";
            }

            if (!$errors) {
                $user = User::findByEmail($email);

                // Message générique pour éviter l’énumération d’emails
                $genericError = "Identifiants invalides.";

                if (!$user || !password_verify($password, $user['password'])) {
                    $errors[] = $genericError;
                } else {
                    // Session
                    if (session_status() !== PHP_SESSION_ACTIVE) {
                        session_start();
                    }

                    session_regenerate_id(true);

                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'role' => $user['role'] ?? 'user',
                    ];

                    header('Location: ' . BASE_URL . '/');
                    exit;
                }
            }
        }

        $this->render('auth/login', [
            'title' => 'Connexion',
            'errors' => $errors
        ]);
    }
}
