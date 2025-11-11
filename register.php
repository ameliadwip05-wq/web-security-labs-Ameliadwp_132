<?php
// register.php
require_once __DIR__ . '/config/db.php';
session_start();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // validasi sederhana
    if ($username === '' || $password === '' || $password2 === '') {
        $errors[] = 'Semua kolom harus diisi.';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Username minimal 3 karakter.';
    } elseif ($password !== $password2) {
        $errors[] = 'Konfirmasi password tidak cocok.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }

    if (empty($errors)) {
        // cek apakah username sudah ada
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = 'Username sudah digunakan.';
            $stmt->close();
        } else {
            $stmt->close();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $ins->bind_param('ss', $username, $hash);
            if ($ins->execute()) {
                $success = true;
            } else {
                $errors[] = 'Gagal mendaftar: ' . $mysqli->error;
            }
            $ins->close();
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Register — Portal Keamanan Web</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/style.css?v=<?php echo filemtime(__DIR__.'/assets/style.css'); ?>">
</head>
<body>
  <div class="auth-box">
    <h2>Daftar Akun</h2>

    <?php if ($success): ?>
      <div class="notice success">Pendaftaran berhasil. <a href="login.php">Masuk sekarang</a>.</div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <div class="notice error">
        <?php foreach ($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?>
      </div>
    <?php endif; ?>

    <form method="post" action="">
      <label>Username
        <input type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
      </label>
      <label>Password
        <input type="password" name="password" required>
      </label>
      <label>Konfirmasi Password
        <input type="password" name="password2" required>
      </label>
      <div style="margin-top:12px;">
        <button type="submit" class="btn">Daftar</button>
        <a href="login.php" class="btn btn-ghost">Sudah punya akun? Masuk</a>
      </div>
    </form>
  </div>
</body>
</html>
