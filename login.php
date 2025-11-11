<?php
// login.php
require_once __DIR__ . '/config/db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Masukkan username dan password.';
    } else {
        $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                // sukses login
                session_regenerate_id(true);
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit;
            } else {
                $error = 'Username atau password salah.';
            }
        } else {
            $error = 'Username atau password salah.';
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login — Portal Keamanan Web</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/style.css?v=<?php echo filemtime(__DIR__.'/assets/style.css'); ?>">
</head>
<body>
  <div class="auth-box">
    <h2>Masuk</h2>

    <?php if ($error): ?>
      <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['registered'])): ?>
      <div class="notice success">Pendaftaran berhasil. Silakan login.</div>
    <?php endif; ?>

    <form method="post" action="">
      <label>Username
        <input type="text" name="username" required>
      </label>
      <label>Password
        <input type="password" name="password" required>
      </label>

      <div style="margin-top:12px;">
        <button type="submit" class="btn">Masuk</button>
        <a href="register.php" class="btn btn-ghost">Daftar</a>
      </div>
    </form>
  </div>
</body>
</html>
