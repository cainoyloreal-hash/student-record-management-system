<?php
require_once __DIR__ . '/includes.php';
require_login();

$total = (int)db()->query('SELECT COUNT(*) FROM students')->fetchColumn();
$recent = db()->query('SELECT * FROM students ORDER BY created_at DESC LIMIT 5')->fetchAll();
$pageTitle = 'Dashboard';
require __DIR__ . '/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <div><h1 class="h3 mb-1">Dashboard</h1><p class="text-secondary mb-0">Manage student information in one place.</p></div>
  <a class="btn btn-primary" href="student_add.php">+ Add Student</a>
</div>
<div class="row g-3 mb-4">
  <div class="col-md-4"><div class="stat-card"><div class="text-secondary">Total students</div><div class="display-5 fw-bold"><?= $total ?></div></div></div>
  <div class="col-md-8"><div class="stat-card h-100 d-flex flex-column justify-content-center"><div class="fw-semibold mb-1">Quick action</div><div class="text-secondary mb-2">Add a student record or browse the existing records.</div><a href="students.php" class="link-primary">View all student records →</a></div></div>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white py-3"><h2 class="h5 mb-0">Recently added students</h2></div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>Student ID</th><th>Name</th><th>Course</th><th>Year</th></tr></thead>
      <tbody>
      <?php if (!$recent): ?><tr><td colspan="4" class="text-center text-secondary py-4">No student records yet. Add your first student.</td></tr>
      <?php else: foreach ($recent as $student): ?>
        <tr><td><?= e($student['student_no']) ?></td><td><?= e($student['first_name'] . ' ' . $student['last_name']) ?></td><td><?= e($student['course']) ?></td><td><?= e($student['year_level']) ?></td></tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
