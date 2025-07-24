<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "0000", "tpi");
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';

    $stmt = $conn->prepare("SELECT id, motdepasse FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $mdp_hash);
        $stmt->fetch();

        if (password_verify($motdepasse, $mdp_hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            echo "Connexion réussie !";
            header("Location: acceuil.html");
            exit;
        } else {
        echo "<script>alert('Mot de passe incorrecte!');
            window.location.href = 'index.html';
        </script>";".";
        }
    } else {
        echo "<script>alert('Adresse email introuvable!');
            window.location.href = 'index.html';
        </script>";".";
    }

    $stmt->close();
}
$conn->close();
?>
