<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Diambil Alih!</title>
</head>
<body onload="alert('⚠️ WEB SUDAH DIAMBIL ALIH!')">
    <h1 style="color: red;">🚨 SISTEM TELAH DIKUASAI! 🚨</h1>
</body>
</html>
