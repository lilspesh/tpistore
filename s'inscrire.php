<?php
$nom = $_POST['nom'];
$numero = $_POST['numero'];
$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];

// Hash du mot de passe
$motdepasse_hash = password_hash($motdepasse, PASSWORD_DEFAULT);

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '0000', 'tpi');
if ($conn->connect_error) {
    die('Connexion échouée : ' . $conn->connect_error);
} else {
    // Vérification si l'email existe déjà
    $check = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Insertion si l'email n'existe pas
        $stmt = $conn->prepare('INSERT INTO users(nom, numero, email, motdepasse) VALUES (?, ?, ?, ?)');
        $stmt->bind_param("siss", $nom, $numero, $email, $motdepasse_hash);

        if ($stmt->execute()) {
            echo "Inscription reussi";
            header('Location: connecter.html');
            exit;
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }

    $check->close();
    $conn->close();
}
?>
