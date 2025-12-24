<h1>Modifier une agence</h1>

<form method="post" action="<?= BASE_URL ?>/admin/agencies/update">
  <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
  <input type="hidden" name="id" value="<?= (int)$agency['id'] ?>">

  <label>Nom</label><br>
  <input type="text" name="name" value="<?= htmlspecialchars($agency['name']) ?>" required>

  <br><br>
  <button type="submit">Enregistrer</button>
  <a href="<?= BASE_URL ?>/admin/agencies">Annuler</a>
</form>
