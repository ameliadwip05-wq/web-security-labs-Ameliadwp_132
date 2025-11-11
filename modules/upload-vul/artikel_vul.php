<?php
require 'config.php';
require_login();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $file_path = null;
    if (!empty($_FILES['file']['name'])) {
        $upload_dir = 'uploads/';
        $file_name = $_FILES['file']['name'];
        $tmp_file = $_FILES['file']['tmp_name'];
        $target = $upload_dir . basename($file_name);

        // ❌ TIDAK ADA VALIDASI — RENTAN!
        if (move_uploaded_file($tmp_file, $target)) {
            $file_path = $target;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO articles (user_id, title, content, file_path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $content, $file_path]);

    $message = "Artikel berhasil disimpan!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Artikel - Versi RENTAN</title>
</head>
<body>
    <h2>Tulis Artikel (Versi RENTAN)</h2>
    <?php if ($message): echo "<p style='color:green'>$message</p>"; endif; ?>

    <form method="post" enctype="multipart/form-data">
        Judul: <input type="text" name="title" required><br><br>
        Isi: <textarea name="content" required></textarea><br><br>
        File (opsional): <input type="file" name="file"><br><br>
        <button type="submit">Simpan Artikel</button>
    </form>

    <p style="color:red; font-weight:bold;">
        ⚠️ PERINGATAN: Versi ini memungkinkan upload file PHP berbahaya!
    </p>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>