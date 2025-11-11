<?php
// config/db.php
// Ubah credential sesuai environment kamu
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'portal_praktikum_v2';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}
// set utf8
$mysqli->set_charset('utf8mb4');
