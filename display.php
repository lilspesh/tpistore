<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage des données</title>
    <link rel="stylesheet" href="style2.css">
</head>
<style>
    button {
      margin-top: 1rem;
      padding: 0.6rem 1.2rem;
      background:rgb(116, 172, 160);
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    button a {
        text-decoration: none;
    }
    button:hover {
      background:rgb(173, 241, 95);
    }
</style>
<body>
    <h1>Rendez-vous a venir</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT name, email, phone, date, time, message FROM apointment";
            $stmt = $pdo->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>". htmlspecialchars($row["date"]) . "</td>";
                echo "<td>". htmlspecialchars($row["time"]) . "</td>";
                echo "<td>". htmlspecialchars($row["message"]) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <p>
        <button href="acceuil.html"><a href="acceuil.html">Acceuil</a></button>
        <button href="index.html"><a href="rendez-vous.html">Prendre rendez-vous</a></button>
    </p>
</body>
</html>
