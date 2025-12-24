<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Créer un trajet') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

  <h1 class="h4 mb-3">Créer un trajet</h1>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $err): ?>
          <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card mb-3">
    <div class="card-body">
      <h2 class="h6">Informations conducteur (non modifiables)</h2>
        <?php
            $first = (string)($user['firstname'] ?? '');
            $last  = (string)($user['lastname'] ?? '');
            $phone = (string)($user['phone'] ?? '');
            ?>
            <p class="mb-1"><strong>Nom :</strong> <?= htmlspecialchars(trim($first . ' ' . $last)) ?></p>
            <p class="mb-1"><strong>Email :</strong> <?= htmlspecialchars((string)($user['email'] ?? '')) ?></p>
            <p class="mb-0"><strong>Téléphone :</strong> <?= htmlspecialchars($phone) ?></p>
    </div>
  </div>

  <form method="post" action="<?= BASE_URL ?>/trip/create" class="row g-3">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

    <div class="col-md-6">
      <label class="form-label">Agence de départ</label>
      <select class="form-select" name="departure_agency_id" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($agencies as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= ((string)$form['departure_agency_id'] === (string)$a['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($a['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Agence d’arrivée</label>
      <select class="form-select" name="arrival_agency_id" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($agencies as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= ((string)$form['arrival_agency_id'] === (string)$a['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($a['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date/heure de départ</label>
      <input class="form-control" type="datetime-local" name="departure_at" value="<?= htmlspecialchars((string)$form['departure_at']) ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date/heure d’arrivée</label>
      <input class="form-control" type="datetime-local" name="arrival_at" value="<?= htmlspecialchars((string)$form['arrival_at']) ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places totales</label>
      <input class="form-control" type="number" name="total_seats" min="1" value="<?= (int)$form['total_seats'] ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places disponibles</label>
      <input class="form-control" type="number" name="available_seats" min="0" value="<?= (int)$form['available_seats'] ?>" required>
      <div class="form-text">En général = places totales au départ.</div>
    </div>

    <div class="col-12">
      <button class="btn btn-primary" type="submit">Créer</button>
      <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>/">Annuler</a>
    </div>
  </form>

</body>
</html>
