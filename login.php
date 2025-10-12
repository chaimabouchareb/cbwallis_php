<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password_hash, is_admin FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($u && password_verify($pass, $u['password_hash'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['is_admin'] = (int)$u['is_admin'];
        header('Location: index.php'); exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title></head><body>
<h1>Login</h1>
<?php if(!empty($error)) echo "<div class='error'>".htmlspecialchars($error)."</div>" ?>
<form method="post">
  <input name="email" type="email" placeholder="Email" required>
  <input name="password" type="password" placeholder="Password" required>
  <button>Login</button>
</form>
<a href="signup.php">Create an account</a>
</body></html>
