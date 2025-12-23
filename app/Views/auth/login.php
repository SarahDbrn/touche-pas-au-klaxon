<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
</head>
<body>
  <h1>Connexion</h1>

  <form method="post" action="/login">
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

  <p><a href="/">Retour accueil</a></p>
</body>
</html>
