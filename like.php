<?php
require_once 'config.php';
header('Content-Type: application/json');
if (!is_logged_in()) { echo json_encode(['ok'=>false,'error'=>'login']); exit; }

$data = json_decode(file_get_contents('php://input'), true);
$wallpaper_id = (int)($data['id'] ?? 0);
$user_id = $_SESSION['user_id'];
if (!$wallpaper_id) { echo json_encode(['ok'=>false]); exit; }

// try insert
try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO likes (user_id, wallpaper_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $wallpaper_id]);

    $pdo->prepare("UPDATE wallpapers SET likes_count = likes_count + 1 WHERE id = ?")->execute([$wallpaper_id]);
    $pdo->commit();

    $cnt = $pdo->prepare("SELECT likes_count FROM wallpapers WHERE id = ?")->execute([$wallpaper_id]);
    $row = $pdo->prepare("SELECT likes_count FROM wallpapers WHERE id = ?");
    $row->execute([$wallpaper_id]);
    $r = $row->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['ok'=>true,'likes'=> (int)($r['likes_count'] ?? 0)]);
} catch (Exception $e) {
    $pdo->rollBack();
    // if duplicate key -> already liked
    echo json_encode(['ok'=>false,'error'=>'already']);
}
