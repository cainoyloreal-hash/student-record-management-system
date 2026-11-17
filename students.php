<?php
require_once __DIR__ . '/includes.php';
require_login();
$q = trim((string)($_GET['q'] ?? ''));
if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt = db()->prepare('SELECT * FROM students WHERE student_no LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR course LIKE ? ORDER BY last_name, first_name');
    $stmt->execute([$like, $like, $like, $like]);
    $students = $stmt->fetchAll();
} else {
    $students = db()->query('SELECT * FROM students ORDER BY last_name, first_name')->fetchAll();
}
$pageTitle = 'Student Records';
require __DIR__ . '/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
 <div><h1 class="h3 mb-1">Student Records</h1><p class="text-secondary mb-0">View, search, update, or remove student information.</p></div>
 <a class="btn btn-primary" href="student_add.php">+ Add Student</a>
</div>
<form class="row g-2 mb-3" method="get">
 <div class="col-sm-9"><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search ID, first name, last name, or course"></div>
 <div class="col-sm-3 d-grid"><button class="btn btn-outline-primary">Search</button></div>
</form>
<div class="card border-0 shadow-sm"><div class="table-responsive">
<table class="table table-hover align-middle mb-0">
<thead><tr><th>Student ID</th><th>Full Name</th><th>Course</th><th>Year</th><th class="text-end">Actions</th></tr></thead>
<tbody>
<?php if (!$students): ?><tr><td colspan="5" class="text-center text-secondary py-4">No matching student records found.</td></tr>
<?php else: foreach ($students as $s): ?>
<tr>
 <td><?= e($s['student_no']) ?></td><td><?= e($s['first_name'].' '.$s['last_name']) ?></td><td><?= e($s['course']) ?></td><td><?= e($s['year_level']) ?></td>
 <td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-secondary" href="student_edit.php?id=<?= (int)$s['id'] ?>">Edit</a>
 <form class="d-inline" method="post" action="student_delete.php" onsubmit="return confirm('Delete this student record?');">
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
  <button class="btn btn-sm btn-outline-danger">Delete</button>
 </form></td>
</tr>
<?php endforeach; endif; ?>
</tbody></table></div></div>
<?php require __DIR__ . '/footer.php'; ?>
