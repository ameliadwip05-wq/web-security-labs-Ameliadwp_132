<?php
// modules/index.php — daftar modul rapi otomatis
$root = __DIR__;

// optional: daftar folder yang tidak mau ditampilkan
$exclude = ['.', '..'];

// optional: meta per modul (judul, deskripsi, entry)
$meta = [
    'broken-access-control' => [
        'title' => 'Broken Access Control',
        'desc'  => 'Latihan mengamankan hak akses antar user.',
        'entry' => 'index.php'
    ],
    'sqlinjection' => [
        'title' => 'SQL Injection',
        'desc'  => 'Latihan eksploitasi SQL Injection sederhana.',
        // tetap ke index.php di dalam folder sqlinjection
        'entry' => 'login_safe.php'
    ],
    'upload-vul' => [
        'title' => 'Upload Vulnerability',
        'desc'  => 'Latihan keamanan dalam file upload.',
        'entry' => 'index.php'
    ],
    'xss' => [
        'title' => 'XSS (Cross-Site Scripting)',
        'desc'  => 'Latihan serangan XSS dan cara mitigasinya.',
        // arahkan langsung ke login.php
        'entry' => 'login.php'
    ],
];

// kumpulkan folder
$items = [];
foreach (scandir($root) as $entry) {
    if (in_array($entry, $exclude)) continue;
    if (is_dir($root . DIRECTORY_SEPARATOR . $entry)) $items[] = $entry;
}
sort($items, SORT_NATURAL | SORT_FLAG_CASE);

// helper buat href aman
function build_href($folder, $meta_item = []) {
    if (!empty($meta_item['entry'])) return htmlspecialchars('modules/' . $folder . '/' . ltrim($meta_item['entry'], '/'));
    return htmlspecialchars('modules/' . $folder . '/');
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Modul — Portal Praktikum</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="/assets/style.css?v=<?php echo filemtime(__DIR__ . '/../assets/style.css'); ?>">
  <style>
    .modules-wrap { max-width:1100px; margin:40px auto; padding:0 18px; }
    .modules-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:24px; }
    .module-card { background:#fff; padding:20px; border-radius:12px; text-align:center; box-shadow:0 10px 30px rgba(16,24,40,0.06); transition:transform .2s; }
    .module-card:hover{ transform:translateY(-6px) }
    .module-card h3{ margin:6px 0 8px; font-size:18px }
    .module-card p{ color:#6b7280; font-size:14px; margin-bottom:12px; min-height:42px }
    .module-card a.btn{ text-decoration:none; padding:8px 14px; border-radius:8px; display:inline-block; background:linear-gradient(90deg,#4f46e5,#60a5fa); color:#fff; font-weight:600;}
    .topbar { text-align:center; margin-bottom:22px; }
  </style>
</head>
<body>
  <div class="modules-wrap">
    <div class="topbar">
      <h1>Modul Praktikum</h1>
      <p class="subheader">Klik modul untuk membuka praktikum <code></code>.</p>
    </div>

    <?php if (empty($items)): ?>
      <div class="notice">Tidak ada modul ditemukan di folder <code>modules/</code>.</div>
    <?php else: ?>
      <div class="modules-grid">
        <?php foreach ($items as $folder):
            $defaultTitle = ucwords(str_replace(['-','_'],' ',$folder));
            $title = $meta[$folder]['title'] ?? $defaultTitle;
            $desc  = $meta[$folder]['desc']  ?? 'Buka modul ' . $title . '.';
            $href  = build_href($folder, $meta[$folder] ?? []);
        ?>
          <div class="module-card">
            <h3><?= htmlspecialchars($title) ?></h3>
            <p><?= htmlspecialchars($desc) ?></p>
            <a class="btn" href="<?= $href ?>">Buka Modul</a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
