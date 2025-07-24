<?php
session_start(); // Démarre une session pour stocker les infos utilisateur

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "0000", "tpi");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $motdepasse = $_POST['motdepasse'] ?? '';
    $email = trim($email);

    // Préparer la requête pour récupérer l'utilisateur
    $stmt = $conn->prepare("SELECT id, motdepasse FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Vérifie si un utilisateur existe avec cet email
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $motdepasse_hash);
        $stmt->fetch();

        // Vérifie le mot de passe
        if (password_verify($motdepasse, $motdepasse_hash)) {
            // Authentification réussie
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            echo "Connexion réussie !";
            // Rediriger vers une page protégée
            header("Location: index.html");
            exit;
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun compte trouvé avec cet email.";
    }

    $stmt->close();
}
$conn->close();
?>
