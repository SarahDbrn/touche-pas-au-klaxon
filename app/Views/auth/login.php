<?php if (!empty($errors)): ?>
  <ul>
    <?php foreach ($errors as $err): ?>
      <li><?= htmlspecialchars($err) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
</head>
<body>
  <h1>Connexion</h1>

  <form method="post" action="<?= BASE_URL ?>/login">
<<<<<<< HEAD
    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect'] ?? '/dashboard') ?>">
=======
>>>>>>> c9a36013a9595e328cf55b0e9fa9bab5f74bd7cc
    <div>
      <label>Email</label><br>
      <input type="email" name="email" required>
    </div>
    <div>
      <label>Mot de passe</label><br>
      <input type="password" name="password" required>
    </div>
    <button type="submit">Se connecter</button>
  </form>

  <p><a href="<?= BASE_URL ?>/">Retour accueil</a></p>
</body>
</html>
