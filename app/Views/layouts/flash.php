<?php
declare(strict_types=1);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

if (!$flash) return;

$type = $flash['type'] ?? 'info';
$message = $flash['message'] ?? '';
?>

<div class="alert alert-<?= htmlspecialchars($type) ?> mt-3" role="alert">
  <?= htmlspecialchars($message) ?>
</div>
