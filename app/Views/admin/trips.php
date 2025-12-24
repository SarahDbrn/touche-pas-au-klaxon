<?php
declare(strict_types=1);
// Vue Admin : liste complète des trajets
// Variables attendues :
// - $trips (array)
// - $csrf (string) token CSRF
?>

<h1 class="h4 mb-3">Trajets</h1>

<?php if (empty($trips)): ?>
  <div class="alert alert-info">
    Aucun trajet pour le moment.
  </div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Départ</th>
          <th>Date/Heure départ</th>
          <th>Destination</th>
          <th>Date/Heure arrivée</th>
          <th>Places</th>
          <th>Auteur</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($trips as $t): ?>
          <tr>
            <td><?= htmlspecialchars($t['departure_agency']) ?></td>
            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['departure_at']))) ?></td>
            <td><?= htmlspecialchars($t['arrival_agency']) ?></td>
            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['arrival_at']))) ?></td>

            <td>
              <?= htmlspecialchars((string)$t['available_seats']) ?>
              /
              <?= htmlspecialchars((string)$t['total_seats']) ?>
            </td>

            <td>
              <?= htmlspecialchars(($t['author_firstname'] ?? '') . ' ' . ($t['author_lastname'] ?? '')) ?>
            </td>

            <td><?= htmlspecialchars($t['author_email'] ?? '') ?></td>

            <td>
              <!-- Suppression admin (POST + CSRF) -->
              <form
                method="post"
                action="<?= BASE_URL ?>/admin/trips/delete"
                class="d-inline"
                onsubmit="return confirm('Supprimer ce trajet ?');"
              >
                <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
                <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
