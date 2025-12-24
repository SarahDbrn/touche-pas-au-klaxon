<?php
declare(strict_types=1);
// Vue : modification d’un trajet
// Layout global actif
?>

<?php if (!empty($errors)): ?>
  <!-- Affichage des erreurs de validation serveur -->
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<h1 class="h4 mb-3">Modifier un trajet</h1>

<!--
  Formulaire d’édition
  - POST (action sensible)
  - CSRF obligatoire
  - id passé dans l’URL (comme tu l’avais déjà)
-->
<form method="post" action="<?= BASE_URL ?>/trip/edit?id=<?= (int)$trip['id'] ?>" class="row g-3">

  <!-- Token CSRF -->
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Auth::csrfToken()) ?>">

  <!-- Agence de départ -->
  <div class="col-md-6">
    <label class="form-label">Agence de départ</label>
    <select class="form-select" name="departure_agency_id" required>
      <?php foreach ($agencies as $a): ?>
        <option
          value="<?= (int)$a['id'] ?>"
          <?= ((int)$trip['departure_agency_id'] === (int)$a['id']) ? 'selected' : '' ?>
        >
          <?= htmlspecialchars($a['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Agence d’arrivée -->
  <div class="col-md-6">
    <label class="form-label">Agence d’arrivée</label>
    <select class="form-select" name="arrival_agency_id" required>
      <?php foreach ($agencies as $a): ?>
        <option
          value="<?= (int)$a['id'] ?>"
          <?= ((int)$trip['arrival_agency_id'] === (int)$a['id']) ? 'selected' : '' ?>
        >
          <?= htmlspecialchars($a['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Date/heure départ -->
  <div class="col-md-6">
    <label class="form-label">Date/heure de départ</label>
    <input
      class="form-control"
      type="datetime-local"
      name="departure_at"
      value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($trip['departure_at']))) ?>"
      required
    >
  </div>

  <!-- Date/heure arrivée -->
  <div class="col-md-6">
    <label class="form-label">Date/heure d’arrivée</label>
    <input
      class="form-control"
      type="datetime-local"
      name="arrival_at"
      value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($trip['arrival_at']))) ?>"
      required
    >
  </div>

  <!-- Places totales -->
  <div class="col-md-6">
    <label class="form-label">Places totales</label>
    <input
      class="form-control"
      type="number"
      name="total_seats"
      min="1"
      value="<?= (int)$trip['total_seats'] ?>"
      required
    >
  </div>

  <!-- Places disponibles -->
  <div class="col-md-6">
    <label class="form-label">Places disponibles</label>
    <input
      class="form-control"
      type="number"
      name="available_seats"
      min="0"
      value="<?= (int)$trip['available_seats'] ?>"
      required
    >
  </div>

  <!-- Boutons -->
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Enregistrer</button>
    <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>/">Annuler</a>
  </div>
</form>
