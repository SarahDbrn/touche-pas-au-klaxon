<?php
declare(strict_types=1);

/**
 * Retourne true si l'utilisateur est connecté
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']) && is_array($_SESSION['user']);
    // ou: return isset($_SESSION['user_id']);
}

/**
 * Redirection propre + exit
 */
function redirectTo(string $path): void
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

/**
 * Page privée -> exige une connexion
 * Bonus: conserve l'URL demandée
 */
function requireLogin(): void
{
    if (isLoggedIn()) {
        return;
    }

    $currentPath = $_SERVER['REQUEST_URI'] ?? '/';
   
    if (defined('BASE_URL') && BASE_URL !== '' && str_starts_with($currentPath, BASE_URL)) {
        $currentPath = substr($currentPath, strlen(BASE_URL));
        if ($currentPath === '') $currentPath = '/';
    }

    $redirect = urlencode($currentPath);
    redirectTo('/login?redirect=' . $redirect);
}

/**
 * Page publique (login/register) -> refuse si déjà connecté
 */
function requireGuest(string $fallback = '/dashboard'): void
{
    if (!isLoggedIn()) {
        return;
    }
    redirectTo($fallback);
}
