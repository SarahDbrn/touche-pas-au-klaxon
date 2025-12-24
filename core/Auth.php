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

/**
 * Retourne l'utilisateur en session ou null
 * @return array<string,mixed>|null
 */
function currentUser(): ?array
{
    return (isset($_SESSION['user']) && is_array($_SESSION['user'])) ? $_SESSION['user'] : null;
}

function currentUserId(): ?int
{
    $u = currentUser();
    return isset($u['id']) ? (int)$u['id'] : null;
}

function isAdmin(): bool
{
    $u = currentUser();
    return isset($u['role']) && $u['role'] === 'ADMIN';
}

/** CSRF */
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(?string $token): bool
{
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Zone admin -> exige login + rôle ADMIN
 */
function requireAdmin(): void
{
    requireLogin();

    if (!isAdmin()) {
        http_response_code(403);
        echo "Accès refusé (admin uniquement).";
        exit;
    }
}
