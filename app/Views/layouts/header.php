<?php
declare(strict_types=1);

$user = function_exists('currentUser') ? currentUser() : null;
$isLoggedIn = function_exists('isLoggedIn') ? isLoggedIn() : false;
$isAdmin = function_exists('isAdmin') ? isAdmin() : false;
?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Touche pas au klaxon') ?></title>

  <!-- Bootstrap (CDN ou ton build Sass si tu l'as) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>
<header class="container py-3">
  <nav class="d-flex justify-content-between align-items-center border rounded-4 p-3">
    <div>
      <?php if ($isAdmin): ?>
        <a class="text-decoration-none fw-semibold" href="<?= BASE_URL ?>/admin">Touche pas au klaxon</a>
      <?php else: ?>
        <a class="text-decoration-none fw-semibold" href="<?= BASE_URL ?>/">Touche pas au klaxon</a>
      <?php endif; ?>
    </div>

    <div class="d-flex gap-2 align-items-center">
      <?php if (!$isLoggedIn): ?>
        <a class="btn btn-dark" href="<?= BASE_URL ?>/login">Connexion</a>

      <?php elseif ($isAdmin): ?>
        <a class="btn btn-secondary" href="<?= BASE_URL ?>/admin/users">Utilisateurs</a>
        <a class="btn btn-secondary" href="<?= BASE_URL ?>/admin/agencies">Agences</a>
        <a class="btn btn-secondary" href="<?= BASE_URL ?>/admin/trips">Trajets</a>

        <form method="post" action="<?= BASE_URL ?>/logout" class="d-inline">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
          <button class="btn btn-dark" type="submit">Déconnexion</button>
        </form>

      <?php else: ?>
        <a class="btn btn-dark" href="<?= BASE_URL ?>/trip/create">Créer un trajet</a>
        <span class="ms-2">Bonjour <?= htmlspecialchars(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')) ?></span>

        <form method="post" action="<?= BASE_URL ?>/logout" class="d-inline">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
          <button class="btn btn-dark" type="submit">Déconnexion</button>
        </form>
      <?php endif; ?>
    </div>
  </nav>
</header>

<main class="container pb-5">
