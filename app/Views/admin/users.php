<h1>Utilisateurs</h1>

<table class="table">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Téléphone</th>
      <th>Rôle</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= htmlspecialchars($u['lastname'] . ' ' . $u['firstname']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['phone'] ?? '') ?></td>
        <td><?= htmlspecialchars($u['role'] ?? '') ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
