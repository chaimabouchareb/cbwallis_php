<?php
require_once 'functions.php';
$recent = fetch_recent_wallpapers(12);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Wallpapers - Home</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'nav.php'; // optional nav include ?>
<main class="container">
  <h1>Free Wallpapers</h1>

  <div class="categories">
    <a class="cat" href="mobile.php">Wallpapers for Mobile</a>
    <a class="cat" href="pc.php">Wallpapers for PC</a>
  </div>

  <h2>Recently added</h2>
  <div class="grid">
    <?php foreach($recent as $w): ?>
      <div class="card">
        <a href="download.php?id=<?= $w['id'] ?>" class="thumb" target="_blank">
          <img src="uploads/<?= htmlspecialchars($w['filename']) ?>" alt="<?= htmlspecialchars($w['title']) ?>" />
        </a>
        <div class="meta">
          <strong><?= htmlspecialchars($w['title']) ?></strong><br>
          <small><?= htmlspecialchars($w['username'] ?? 'Unknown') ?> • <?= $w['category'] ?></small>
        </div>
        <div class="actions">
          <?php if(is_logged_in()): ?>
            <button class="like-btn" data-id="<?= $w['id'] ?>">❤ <span class="count"><?= $w['likes_count'] ?></span></button>
          <?php else: ?>
            <a href="login.php">❤ <?= $w['likes_count'] ?></a>
          <?php endif; ?>
          <a class="download-btn" href="download.php?id=<?= $w['id'] ?>">Download</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<script src="js/script.js"></script>
</body>
</html>
