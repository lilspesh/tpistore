<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "0000", "tpi");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'] ?? '';
    $motdepasse = $_POST['motdepasse'] ?? '';

    // Nettoyer les données (optionnel mais recommandé)
    $email = trim($email);

    // Vérifier si l’email est déjà utilisé
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Cet email est déjà utilisé. Veuillez en choisir un autre!');
            window.location.href = 's'incrire.html';
        </script>";".";
    } else {
        // Hasher le mot de passe
        $mdp_hash = password_hash($motdepasse, PASSWORD_DEFAULT);

        // Insérer le nouvel utilisateur
        $stmt = $conn->prepare("INSERT INTO users (email, motdepasse) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $mdp_hash);

        if ($stmt->execute()) {
            echo "Inscription réussie !";
            header('Location: index.html');
            exit;
            // Rediriger ou afficher un lien vers la page de connexion
        } else {
            echo "<script>alert('Erreur lors de l'inscription. Veuillez réessayer!');
            window.location.href = 's'incrire.html';
        </script>";".";
        }
    }

    $stmt->close();
}
$conn->close();
?>
