<?php
// index.php
require_once __DIR__ . '/config/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Folder modul
$modulesDir = __DIR__ . '/modules';
$exclude = ['.', '..'];

// Meta untuk tiap modul
$meta = [
    'sqlinjection' => [
        'title' => 'SQL Injection',
        'desc'  => 'Latihan eksploitasi SQL Injection sederhana.',
        'entry' => 'login_safe.php'
    ],
    'xss' => [
        'title' => 'XSS (Cross-Site Scripting)',
        'desc'  => 'Latihan serangan XSS dan cara mitigasinya.',
        'entry' => 'login.php'
    ],
    'upload-vul' => [
        'title' => 'Upload Vulnerability',
        'desc'  => 'Latihan keamanan dalam file upload.',
        'entry' => 'index.php'
    ],
    'broken-access-control' => [
        'title' => 'Broken Access Control',
        'desc'  => 'Latihan mengamankan hak akses antar user.',
        'entry' => 'index.php'
    ]
];

// Ambil semua folder modul
$items = [];
foreach (scandir($modulesDir) as $entry) {
    if (in_array($entry, $exclude)) continue;
    if (is_dir($modulesDir . DIRECTORY_SEPARATOR . $entry)) {
        $items[] = $entry;
    }
}
sort($items, SORT_NATURAL | SORT_FLAG_CASE);

// Fungsi untuk membangun URL modul
function build_href($folder, $meta_item = [])
{
    $entry = $meta_item['entry'] ?? 'index.php';
    return 'modules/' . $folder . '/' . ltrim($entry, '/');
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Portal Keamanan Web</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/style.css?v=<?php echo filemtime(__DIR__.'/assets/style.css'); ?>">
</head>
<body>
  <header class="header">
    <img src="assets/brain-icon.png" alt="logo" onerror="this.src='https://cdn-icons-png.flaticon.com/512/1995/1995524.png'">
    <h1 style="text-align:center;">Portal Keamanan Web</h1>
    <p class="subheader" style="text-align:center;">Kumpulan latihan keamanan aplikasi web berbasis PHP.</p>
    <div style="margin-top:10px;text-align:center;">
      <span class="small">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      <a href="logout.php" class="btn btn-ghost" style="margin-left:10px;">Keluar</a>
    </div>
  </header>

  <main class="main-container" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;padding:20px;">
    <?php if (count($items) === 0): ?>
      <div class="notice">Tidak ada folder praktikum ditemukan.</div>
    <?php endif; ?>

    <?php foreach ($items as $folder):
        $defaultTitle = ucwords(str_replace(['-', '_'], ' ', $folder));
        $title = $meta[$folder]['title'] ?? $defaultTitle;
        $desc  = $meta[$folder]['desc']  ?? 'Buka praktikum ' . $title . '.';
        $href  = build_href($folder, $meta[$folder] ?? []);
    ?>
      <article class="card" style="background:#fff;border-radius:15px;box-shadow:0 4px 8px rgba(0,0,0,0.1);padding:20px;text-align:center;transition:all 0.3s;">
        <h3 style="margin-bottom:10px;"><?php echo htmlspecialchars($title); ?></h3>
        <p style="color:#666;margin-bottom:15px;"><?php echo htmlspecialchars($desc); ?></p>
        <a class="btn" href="<?php echo $href; ?>" style="display:inline-block;background:#007BFF;color:white;padding:10px 20px;border-radius:8px;text-decoration:none;">Buka Praktikum</a>
      </article>
    <?php endforeach; ?>
  </main>

  <footer class="site-footer" style="text-align:center;padding:15px 0;background:#f5f5f5;margin-top:30px;">
    &copy; <?php echo date('Y'); ?> Portal Keamanan Web — Praktikum Keamanan Web
  </footer>
</body>
</html>
