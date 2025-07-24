<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $correctPassword = 'admin1234'; // 🔐 Change this default password

    if ($password === $correctPassword) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: display.php');
        exit;
    } else {
        $error = 'Mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #5cb85c;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #4cae4c;
        }

        .error {
            color: red;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Connexion Admin</h2>
    <form method="POST">
        <input type="password" name="password" placeholder="Mot de passe admin" required>
        <button type="submit">Se connecter</button>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </form>
</div>

</body>
</html>

