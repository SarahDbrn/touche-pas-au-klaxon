<?php if (!empty($_SESSION['flash_success'])): ?>
  <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
  <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<h1>Modifier un trajet</h1>

<form method="post" action="<?= BASE_URL ?>/trip/edit?id=<?= (int)$trip['id'] ?>">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

  <div>
    <label>Agence de départ</label><br>
    <select name="departure_agency_id" required>
      <?php foreach ($agencies as $a): ?>
        <option value="<?= (int)$a['id'] ?>" <?= ((int)$trip['departure_agency_id'] === (int)$a['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($a['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label>Agence d’arrivée</label><br>
    <select name="arrival_agency_id" required>
      <?php foreach ($agencies as $a): ?>
        <option value="<?= (int)$a['id'] ?>" <?= ((int)$trip['arrival_agency_id'] === (int)$a['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($a['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label>Départ</label><br>
    <input type="datetime-local" name="departure_at"
      value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($trip['departure_at']))) ?>" required>
  </div>

  <div>
    <label>Arrivée</label><br>
    <input type="datetime-local" name="arrival_at"
      value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($trip['arrival_at']))) ?>" required>
  </div>

  <div>
    <label>Places totales</label><br>
    <input type="number" name="total_seats" min="1" value="<?= (int)$trip['total_seats'] ?>" required>
  </div>

  <div>
    <label>Places disponibles</label><br>
    <input type="number" name="available_seats" min="0" value="<?= (int)$trip['available_seats'] ?>" required>
  </div>

  <button type="submit">Enregistrer</button>
  <a href="<?= BASE_URL ?>/">Annuler</a>
</form>
