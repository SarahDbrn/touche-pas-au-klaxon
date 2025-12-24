<?php
declare(strict_types=1);
// Vue : formulaire de connexion
// Le header, le footer et Bootstrap sont fournis par le layout global
?>

<?php if (!empty($errors)): ?>
  <!-- Affichage des erreurs de connexion (email incorrect, mot de passe invalide, etc.) -->
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<!-- Titre de la page -->
<h1 class="mb-4">Connexion</h1>

<!--
  Formulaire de connexion
  - Méthode POST (sécurité)
  - Action vers la route /login
-->
<form method="post" action="<?= BASE_URL ?>/login" class="mb-3">

  <!--
    Champ caché de redirection
    Permet de rediriger l’utilisateur vers la page demandée initialement
    (ex : accès à /trip/create sans être connecté)
  -->
  <input
    type="hidden"
    name="redirect"
    value="<?= htmlspecialchars($_GET['redirect'] ?? '/dashboard') ?>"
  >

  <!-- Champ email -->
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input
      id="email"
      class="form-control"
      type="email"
      name="email"
      required
    >
  </div>

  <!-- Champ mot de passe -->
  <div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <input
      id="password"
      class="form-control"
      type="password"
      name="password"
      required
    >
  </div>

  <!-- Bouton de soumission -->
  <button class="btn btn-dark" type="submit">
    Se connecter
  </button>
</form>

<!-- Lien de retour vers l’accueil -->
<p>
  <a href="<?= BASE_URL ?>/">← Retour à l’accueil</a>
</p>
