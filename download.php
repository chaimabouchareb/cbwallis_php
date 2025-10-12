<?php
require_once 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM wallpapers WHERE id = ?");
$stmt->execute([$id]);
$w = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$w) { http_response_code(404); exit('Not found'); }

$path = __DIR__ . '/uploads/' . $w['filename'];
if (!file_exists($path)) { http_response_code(404); exit('File missing'); }

// Optionally log downloads in DB (not included). Force download:
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($w['original_filename'] ?: $w['filename']).'"');
header('Content-Length: ' . filesize($path));
readfile($path);
exit;
