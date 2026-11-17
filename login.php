<?php
require_once __DIR__ . '/includes.php';
if (!empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $stmt = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    }
    $error = 'Incorrect username or password.';
}
$pageTitle = 'Admin Login';
require __DIR__ . '/header.php';
?>
<div class="row justify-content-center py-4">
 <div class="col-md-6 col-lg-5">
  <div class="card border-0 shadow-sm">
   <div class="card-body p-4 p-md-5">
    <h1 class="h3 mb-1">Administrator Login</h1>
    <p class="text-secondary mb-4">Sign in to manage student records.</p>
    <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" required autofocus autocomplete="username"></div>
      <div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control" type="password" id="password" name="password" required autocomplete="current-password"></div>
      <button class="btn btn-primary w-100" type="submit">Log in</button>
    </form>
   </div>
  </div>
 </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
