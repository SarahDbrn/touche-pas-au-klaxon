<?php
declare(strict_types=1);
// Vue : tableau de bord utilisateur
// Accessible uniquement aux utilisateurs connectés
// Le header et le footer sont fournis par le layout global
?>

<!-- Titre principal de la page -->
<h1 class="mb-3">Dashboard</h1>

<!-- Message de confirmation de connexion -->
<p class="alert alert-success">
  ✅ Page privée : vous êtes connecté(e).
</p>

<!--
  Zone d’informations ou d’actions futures
  (ex : statistiques, raccourcis, liens rapides)
-->
<p class="text-muted">
  Cet espace est réservé aux utilisateurs authentifiés.
</p>

<!-- Lien de retour vers la page d’accueil -->
<p>
  <a href="<?= BASE_URL ?>/">← Retour à l’accueil</a>
</p>
