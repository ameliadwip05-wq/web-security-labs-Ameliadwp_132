<?php
require 'config.php';
require_login();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Demo App</title>
</head>
<body>
    <h1>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    <nav>
        <p>
            <a href="artikel_vul.php">📝 Artikel (Versi RENTAN)</a> |
            <a href="artikel_safe.php">✅ Artikel (Versi AMAN)</a> |
            <a href="logout.php">Logout</a>
        </p>
    </nav>
    <h2>Menu Utama</h2>
    <p>Ini adalah dashboard setelah login.</p>
</body>
</html>