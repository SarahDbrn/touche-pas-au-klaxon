<?php
declare(strict_types=1);

/**
 * Layout global — HEADER
 *
 * Ce fichier est inclus automatiquement par Controller::render()
 * Il est chargé AVANT chaque vue.
 *
 * Authentification :
 * - Le projet utilise des fonctions helper (pas de classe Auth)
 * - Les fonctions sont définies dans core/Auth.php
 */

// Récupération des informations utilisateur via les helpers
$user = function_exists('currentUser') ? currentUser() : null;
$isLoggedIn = function_exists('isLoggedIn') ? isLoggedIn() : false;
$isAdmin = function_exists('isAdmin') ? isAdmin() : false;
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">

  <!-- Responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Titre dynamique -->
  <title><?= htmlspecialchars($title ?? 'Touche pas au klaxon') ?></title>

  <!-- Bootstrap CSS (CDN) -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  <!-- Styles personnalisés -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

<!-- En-tête principal -->
<header class="container py-3">
  <nav class="d-flex justify-content-between align-items-center border rounded-4 p-3">

    <!-- Logo / lien principal -->
    <div>
      <?php if ($isAdmin): ?>
        <!-- L’admin arrive sur son dashboard -->
        <a class="text-decoration-none fw-semibold" href="<?= BASE_URL ?>/admin">
          Touche pas au klaxon
        </a>
      <?php else: ?>
        <!-- Utilisateur ou visiteur : accueil -->
        <a class="text-decoration-none fw-semibold" href="<?= BASE_URL ?>/">
          Touche pas au klaxon
        </a>
      <?php endif; ?>
    </div>

    <!-- Zone actions utilisateur -->
    <div class="d-flex gap-2 align-items-center">

      <?php if (!$isLoggedIn): ?>
        <!-- Visiteur : lien de connexion -->
        <a class="btn btn-dark" href="<?= BASE_URL ?>/login">
          Connexion
        </a>

      <?php elseif ($isAdmin): ?>
        <!-- Admin : navigation dédiée -->
        <a class="btn btn-secondary" href="<?= BASE_URL ?>/admin/users">
          Utilisateurs
        </a>
        <a class="btn btn-secondary" href="<?= BASE_URL ?>/admin/agencies">
          Agences
        </a>
        <a class="btn btn-secondary" href="<?= BASE_URL ?>/admin/trips">
          Trajets
        </a>

        <!-- Déconnexion admin (POST + CSRF) -->
        <form method="post" action="<?= BASE_URL ?>/logout" class="d-inline">
          <input
            type="hidden"
            name="csrf"
            value="<?= htmlspecialchars(csrfToken()) ?>"
          >
          <button class="btn btn-dark" type="submit">
            Déconnexion
          </button>
        </form>

      <?php else: ?>
        <!-- Utilisateur connecté (non admin) -->
        <a class="btn btn-dark" href="<?= BASE_URL ?>/trip/create">
          Créer un trajet
        </a>

        <span class="ms-2">
          Bonjour <?= htmlspecialchars(
            ($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')
          ) ?>
        </span>

        <!-- Déconnexion utilisateur (POST + CSRF) -->
        <form method="post" action="<?= BASE_URL ?>/logout" class="d-inline">
          <input
            type="hidden"
            name="csrf"
            value="<?= htmlspecialchars(csrfToken()) ?>"
          >
          <button class="btn btn-dark" type="submit">
            Déconnexion
          </button>
        </form>

      <?php endif; ?>

    </div>
  </nav>
</header>

<!-- Début du contenu principal -->
<main class="container pb-5">
