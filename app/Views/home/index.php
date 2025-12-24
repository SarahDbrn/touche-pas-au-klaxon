<?php
declare(strict_types=1);
// Vue "Accueil" — affichée dans <main> via le layout global
?>

<?php if (function_exists('isLoggedIn') && !isLoggedIn()): ?>
  <!-- Message visible uniquement pour les visiteurs non connectés -->
  <p class="mt-3">
    Pour obtenir plus d'informations sur un trajet, veuillez vous connecter.
  </p>
<?php endif; ?>

<!-- Titre de la page -->
<h2 class="h4 mb-3">Trajets disponibles</h2>

<?php if (empty($trips)): ?>
  <!-- Cas où aucun trajet n’est disponible -->
  <div class="alert alert-info">
    Aucun trajet disponible pour le moment.
  </div>

<?php else: ?>
  <!-- Tableau responsive Bootstrap -->
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Départ</th>
          <th>Date/Heure départ</th>
          <th>Destination</th>
          <th>Date/Heure arrivée</th>
          <th>Places dispo</th>

          <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
            <th>Détails</th>
            <th>Actions</th>
          <?php endif; ?>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($trips as $trip): ?>
          <tr>
            <td><?= htmlspecialchars($trip['departure_agency']) ?></td>
            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($trip['departure_at']))) ?></td>
            <td><?= htmlspecialchars($trip['arrival_agency']) ?></td>
            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($trip['arrival_at']))) ?></td>

            <td>
              <span class="badge text-bg-success">
                <?= htmlspecialchars((string)$trip['available_seats']) ?>
              </span>
            </td>

            <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
              <!-- Bouton modale détails -->
              <td>
                <button
                  type="button"
                  class="btn btn-sm btn-outline-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#tripModal<?= (int)$trip['id'] ?>"
                >
                  Voir
                </button>
              </td>

              <!-- Actions (modifier/supprimer) si auteur ou admin -->
              <td>
                <?php
                  $canManage = function_exists('isAdmin') && isAdmin();

                  if (!$canManage && function_exists('currentUserId')) {
                      $canManage = ((int)$trip['author_id'] === (int)currentUserId());
                  }
                ?>

                <?php if ($canManage): ?>
                  <a
                    class="btn btn-sm btn-outline-secondary"
                    href="<?= BASE_URL ?>/trip/edit?id=<?= (int)$trip['id'] ?>"
                  >
                    Modifier
                  </a>

                  <form
                    method="post"
                    action="<?= BASE_URL ?>/trip/delete"
                    class="d-inline"
                    onsubmit="return confirm('Supprimer ce trajet ?');"
                  >
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                    <input type="hidden" name="id" value="<?= (int)$trip['id'] ?>">
                    <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                  </form>
                <?php else: ?>
                  <span class="text-muted">—</span>
                <?php endif; ?>
              </td>
            <?php endif; ?>
          </tr>

          <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
            <!-- Modale détails conducteur -->
            <div class="modal fade" id="tripModal<?= (int)$trip['id'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Détails du trajet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                  </div>

                  <div class="modal-body">
                    <p class="mb-2">
                      <strong>Proposé par :</strong>
                      <?= htmlspecialchars(($trip['contact_firstname'] ?? '') . ' ' . ($trip['contact_lastname'] ?? '')) ?>
                    </p>
                    <p class="mb-2">
                      <strong>Téléphone :</strong>
                      <?= htmlspecialchars($trip['contact_phone'] ?? '') ?>
                    </p>
                    <p class="mb-2">
                      <strong>Email :</strong>
                      <?= htmlspecialchars($trip['contact_email'] ?? '') ?>
                    </p>
                    <p class="mb-0">
                      <strong>Places totales :</strong>
                      <?= htmlspecialchars((string)($trip['total_seats'] ?? '')) ?>
                    </p>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
