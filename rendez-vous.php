<?php
$host = 'localhost';
$db = 'tpi';
$user = 'root';
$pass = '0000'; // Use your DB password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name     = $_POST['name'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$date     = $_POST['date'];
$time     = $_POST['time'];
$message  = $_POST['message'];

$sql = "INSERT INTO apointment (name, email, phone, date, time, message)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $phone, $date, $time, $message);

if ($stmt->execute()) {
    echo "<script>alert('Rendez-vous enregisrer avec succes!');
            window.location.href = 'display.php';
        </script>";".";
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
