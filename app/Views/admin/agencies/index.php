<h1>Agences</h1>

<?php if (!empty($_SESSION['flash'])): ?>
  <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
    <?= htmlspecialchars($_SESSION['flash']['message']) ?>
  </div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<h2>Ajouter une agence</h2>
<form method="post" action="<?= BASE_URL ?>/admin/agencies/create">
  <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
  <input type="text" name="name" placeholder="Nom de l'agence" required>
  <button type="submit">Créer</button>
</form>

<h2>Liste</h2>
<table class="table">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($agencies as $a): ?>
      <tr>
        <td><?= htmlspecialchars($a['name']) ?></td>
        <td>
          <a href="<?= BASE_URL ?>/admin/agencies/edit?id=<?= (int)$a['id'] ?>">Modifier</a>

          <form method="post" action="<?= BASE_URL ?>/admin/agencies/delete" style="display:inline">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
            <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
            <button type="submit" onclick="return confirm('Supprimer cette agence ?')">Supprimer</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
