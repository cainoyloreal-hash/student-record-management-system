<?php
require_once __DIR__ . '/includes.php';
require_login();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Invalid student ID.'); }
$stmt = db()->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) { http_response_code(404); exit('Student record not found.'); }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $fields = ['student_no','first_name','last_name','gender','course','year_level','email','contact_no'];
    foreach ($fields as $key) { $student[$key] = trim((string)($_POST[$key] ?? '')); }
    if ($student['student_no']==='' || $student['first_name']==='' || $student['last_name']==='' || $student['course']==='' || $student['year_level']==='') {
        $error = 'Please complete all required fields.';
    } elseif ($student['email'] !== '' && !filter_var($student['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $update = db()->prepare('UPDATE students SET student_no=?, first_name=?, last_name=?, gender=?, course=?, year_level=?, email=?, contact_no=? WHERE id=?');
            $update->execute([...array_map(fn($k) => $student[$k], $fields), $id]);
            flash('success', 'Student record updated successfully.');
            header('Location: students.php'); exit;
        } catch (PDOException $ex) {
            $error = $ex->getCode() === '23000' ? 'That Student ID is already used by another record.' : 'Could not update the record.';
        }
    }
}
$pageTitle = 'Edit Student';
require __DIR__ . '/header.php';
?>
<h1 class="h3 mb-3">Edit Student</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<?php $actionLabel = 'Update Student'; require __DIR__ . '/student_form.php'; ?>
<?php require __DIR__ . '/footer.php'; ?>
