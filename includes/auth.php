<?php
// includes/auth.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /portal_praktikum/login.php');
    exit;
}
