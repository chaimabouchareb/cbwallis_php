<?php
// mobile.php (pc.php same but category='pc')
require_once 'functions.php';
$category = 'mobile';
$wallpapers = fetch_wallpapers_by_category($category, 100);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Mobile Wallpapers</title>
<link rel="stylesheet" href="css/style.css"></head><body>
<?php include 'nav.php'; ?>
<main>
  <h1>Mobile Wallpapers</h1>
  <div class="grid">
    <?php foreach($wallpapers as $w): ?>
      <div class="card">
         <a href="download.php?id=<?= $w['id'] ?>" class="thumb" target="_blank">
           <img src="uploads/<?= htmlspecialchars($w['filename']) ?>" alt="<?= htmlspecialchars($w['title']) ?>" />
         </a>
         <div class="meta"><?= htmlspecialchars($w['title']) ?></div>
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
</body></html>
