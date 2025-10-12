<?php
// nav.php
?>
<nav>
  <a href="index.php">Home</a> |
  <a href="mobile.php">Mobile</a> |
  <a href="pc.php">PC</a> |
  <?php if(is_logged_in()): ?>
    <a href="upload.php">Upload</a> |
    <?php if(is_admin()): ?><a href="admin.php">Admin</a> |<?php endif; ?>
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="login.php">Login</a> | <a href="signup.php">Sign up</a>
  <?php endif; ?>
</nav>
