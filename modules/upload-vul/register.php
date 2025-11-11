<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        echo "<p style='color:green'>Registrasi berhasil! <a href='index.php'>Login</a></p>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<p style='color:red'>Username sudah digunakan!</p>";
        } else {
            echo "<p style='color:red'>Terjadi kesalahan.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Demo App</title>
</head>
<body>
    <h2>Daftar Akun Baru</h2>
    <form method="post">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="index.php">Login</a></p>
</body>
</html>