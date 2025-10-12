<?php
require_once 'config.php';
if (!is_admin()) { header('Location: index.php'); exit; }

// delete action
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // fetch filename
    $stmt = $pdo->prepare("SELECT filename FROM wallpapers WHERE id = ?");
    $stmt->execute([$id]);
    $w = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($w) {
        $pdo->prepare("DELETE FROM wallpapers WHERE id = ?")->execute([$id]);
        @unlink(__DIR__.'/uploads/'.$w['filename']);
    }
    header('Location: admin.php'); exit;
}

$rows = $pdo->query("SELECT w.*, u.username FROM wallpapers w LEFT JOIN users u ON u.id = w.uploader_id ORDER BY added_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin</title></head><body>
<?php include 'nav.php'; ?>
<h1>Admin Dashboard</h1>
<table border="1">
<tr><th>ID</th><th>Title</th><th>Category</th><th>Uploader</th><th>Likes</th><th>Actions</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?= $r['id'] ?></td>
  <td><?= htmlspecialchars($r['title']) ?></td>
  <td><?= $r['category'] ?></td>
  <td><?= htmlspecialchars($r['username'] ?? '—') ?></td>
  <td><?= $r['likes_count'] ?></td>
  <td><a href="admin.php?delete=<?= $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
