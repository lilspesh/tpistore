<?php
// Connexion à la base MySQL (modifie avec tes infos)
$host = 'localhost';
$dbname = 'tpi';
$user = 'root';
$pass = '0000';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des rendez-vous
    $stmt = $pdo->query("SELECT * FROM apointment ORDER BY date, time");
    $rendezvous = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Gestion des Rendez-vous</title>
  <style>
    /* (même CSS que tu as fourni) */
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #343a40;
      color: white;
      padding: 20px;
      text-align: center;
    }
    .container {
      max-width: 1000px;
      margin: 30px auto;
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    .actions button {
      margin-right: 5px;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
    }
    .edit-btn { background-color: #ffc107; }
    .delete-btn { background-color: #dc3545; }
    .validate-btn { background-color: #28a745; }
    .actions button:hover { opacity: 0.9; }
    /* Modal (peut rester en place si tu veux gérer actions JS ensuite) */
    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 10px;
      width: 300px;
    }
    .modal-content input {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
    }
    .modal-content button {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Panel Admin - Rendez-vous</h1>
  </header>

  <div class="container">
    <h2>Liste des rendez-vous</h2>
    <table id="rdv-table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Date</th>
          <th>Heure</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rendezvous as $rdv): ?>
          <tr data-id="<?= htmlspecialchars($rdv['id']) ?>">
            <td><?= htmlspecialchars($rdv['name']) ?></td>
            <td><?= htmlspecialchars($rdv['email']) ?></td>
            <td><?= htmlspecialchars($rdv['phone']) ?></td>
            <td><?= htmlspecialchars($rdv['date']) ?></td>
            <td><?= htmlspecialchars($rdv['time']) ?></td>
            <td><?= htmlspecialchars($rdv['message']) ?></td>
            <td><?= htmlspecialchars($rdv['statut']) ?></td>
            <td class="actions">
              <button class="edit-btn" data-id="<?= htmlspecialchars($rdv['id']) ?>">Modifier</button>
              <button class="delete-btn" data-id="<?= htmlspecialchars($rdv['id']) ?>">Supprimer</button>
              <button class="validate-btn" data-id="<?= htmlspecialchars($rdv['id']) ?>" <?= $rdv['statut'] === 'Validé' ? 'disabled' : '' ?>>
                <?= $rdv['statut'] === 'Validé' ? '✔' : 'Valider' ?>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal ici si tu veux -->

  <script>
    // Tu peux reprendre ton JS actuel ici pour gérer modifier, supprimer, valider via AJAX vers un autre PHP
  </script>
</body>
</html>
