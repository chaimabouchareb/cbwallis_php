<?php
// config.php
session_start();

$DB_HOST = 'localhost';
$DB_NAME = 'wallpaper_site';
$DB_USER = 'root';
$DB_PASS = ''; // set your password

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    die('DB connection failed: ' . $e->getMessage());
}

// helper to check logged in
function is_logged_in() {
    return !empty($_SESSION['user_id']);
}
function is_admin() {
    return !empty($_SESSION['is_admin']);
}
?>
