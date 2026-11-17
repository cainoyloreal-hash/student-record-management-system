<?php
/*
 * Run once after importing database.sql and configuring config/database.php.
 * Open http://SERVER-IP/setup_admin.php, create the admin, then DELETE this file.
 */
require_once __DIR__ . '/includes.php';
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if (!preg_match('/^[a-zA-Z0-9_.-]{4,40}$/', $username)) {
        $error = 'Username must be 4–40 characters and use letters, numbers, dot, dash, or underscore.';
    } elseif (strlen($password) < 10) {
        $error = 'Password must be at least 10 characters.';
    } else {
        $count = (int)db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
        if ($count > 0) {
            $error = 'An administrator already exists. Delete this setup file for security.';
        } else {
            $stmt = db()->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)');
            $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
            $message = 'Administrator created. Log in, then delete setup_admin.php from the server.';
        }
    }
}
$pageTitle = 'Create Administrator';
require __DIR__ . '/header.php';
?>
<div class="row justify-content-center"><div class="col-md-6"><div class="card border-0 shadow-sm"><div class="card-body p-4">
<h1 class="h4 mb-3">Create Administrator</h1>
<?php if ($message): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<?php if (!$message): ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="mb-3"><label class="form-label">Admin username</label><input class="form-control" name="username" minlength="4" maxlength="40" required></div>
<div class="mb-3"><label class="form-label">Admin password</label><input class="form-control" type="password" name="password" minlength="10" required><div class="form-text">Use at least 10 characters.</div></div>
<button class="btn btn-primary">Create Administrator</button>
</form>
<?php endif; ?>
</div></div></div></div>
<?php require __DIR__ . '/footer.php'; ?>
