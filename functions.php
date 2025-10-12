<?php
// functions.php
require_once 'config.php';

function get_user_by_id($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, username, email, is_admin FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetch_recent_wallpapers($limit = 12) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT w.*, u.username FROM wallpapers w LEFT JOIN users u ON w.uploader_id = u.id ORDER BY added_at DESC LIMIT ?");
    $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetch_wallpapers_by_category($category, $limit = 50) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT w.*, u.username FROM wallpapers w LEFT JOIN users u ON w.uploader_id = u.id WHERE category = ? ORDER BY added_at DESC LIMIT ?");
    $stmt->bindValue(1, $category);
    $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
