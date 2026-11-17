<?php
require_once __DIR__ . '/includes.php';
$pageTitle = $pageTitle ?? 'Student Records';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | Student Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Student Records</a>
    <?php if (!empty($_SESSION['admin_id'])): ?>
      <div class="d-flex align-items-center gap-3">
        <span class="text-white-50 small d-none d-sm-inline">Admin: <?= e($_SESSION['admin_username'] ?? 'Administrator') ?></span>
        <a class="btn btn-sm btn-outline-light" href="logout.php">Log out</a>
      </div>
    <?php endif; ?>
  </div>
</nav>
<main class="container py-4">
<?php if ($flash = get_flash()): ?>
  <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
    <?= e($flash['message']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
