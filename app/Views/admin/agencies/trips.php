<h1>Trajets</h1>

<?php if (!empty($_SESSION['flash'])): ?>
  <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
    <?= htmlspecialchars($_SESSION['flash']['message']) ?>
  </div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<table class="table">
  <thead>
    <tr>
      <th>Départ</th>
      <th>Date/Heure</th>
      <th>Destination</th>
      <th>Date/Heure</th>
      <th>Places</th>
      <th>Auteur</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($trips as $t): ?>
      <tr>
        <td><?= htmlspecialchars($t['departure_agency']) ?></td>
        <td><?= htmlspecialchars($t['departure_at']) ?></td>
        <td><?= htmlspecialchars($t['arrival_agency']) ?></td>
        <td><?= htmlspecialchars($t['arrival_at']) ?></td>
        <td><?= (int)$t['available_seats'] ?> / <?= (int)$t['total_seats'] ?></td>
        <td><?= htmlspecialchars(($t['author_firstname'] ?? '') . ' ' . ($t['author_lastname'] ?? '')) ?></td>
        <td>
          <form method="post" action="<?= BASE_URL ?>/admin/trips/delete" style="display:inline">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
            <button type="submit" onclick="return confirm('Supprimer ce trajet ?')">Supprimer</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
