<?php
require_once 'config.php';
if (!is_logged_in()) {
    header('Location: login.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category = $_POST['category'] === 'pc' ? 'pc' : 'mobile';
    if (empty($_FILES['wallpaper']) || $_FILES['wallpaper']['error'] !== UPLOAD_ERR_OK) {
        $error = "Upload failed.";
    } else {
        $f = $_FILES['wallpaper'];
        $allowed = ['image/jpeg','image/png','image/webp'];
        if (!in_array($f['type'], $allowed)) $error = "Only JPG/PNG/WEBP allowed.";
        if ($f['size'] > 5*1024*1024) $error = "Max 5MB.";
        if (!isset($error)) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $newname = bin2hex(random_bytes(8)) . '.' . $ext;
            $dest = __DIR__ . '/uploads/' . $newname;
            if (!move_uploaded_file($f['tmp_name'], $dest)) $error = "Move failed.";
            else {
                $stmt = $pdo->prepare("INSERT INTO wallpapers (title, filename, original_filename, category, uploader_id) VALUES (?,?,?,?,?)");
                $stmt->execute([$title ?: 'Untitled', $newname, $f['name'], $category, $_SESSION['user_id']]);
                header('Location: index.php'); exit;
            }
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Upload Wallpaper</title></head>
<body>
<?php include 'nav.php'; ?>
<h1>Upload Wallpaper</h1>
<?php if(!empty($error)) echo "<p class='error'>".htmlspecialchars($error)."</p>" ?>
<form method="post" enctype="multipart/form-data">
  <input name="title" placeholder="Title (optional)">
  <select name="category">
    <option value="mobile">Mobile</option>
    <option value="pc">PC</option>
  </select>
  <input type="file" name="wallpaper" accept=".png,.jpg,.jpeg,.webp" required>
  <button>Upload</button>
</form>
</body></html>
