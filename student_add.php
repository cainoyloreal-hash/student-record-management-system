<?php
require_once __DIR__ . '/includes.php';
require_login();
$student = ['student_no'=>'','first_name'=>'','last_name'=>'','gender'=>'','course'=>'','year_level'=>'','email'=>'','contact_no'=>''];
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    foreach ($student as $key => $_) { $student[$key] = trim((string)($_POST[$key] ?? '')); }
    if ($student['student_no']==='' || $student['first_name']==='' || $student['last_name']==='' || $student['course']==='' || $student['year_level']==='') {
        $error = 'Please complete all required fields.';
    } elseif ($student['email'] !== '' && !filter_var($student['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $stmt = db()->prepare('INSERT INTO students (student_no, first_name, last_name, gender, course, year_level, email, contact_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute(array_values($student));
            flash('success', 'Student record added successfully.');
            header('Location: students.php'); exit;
        } catch (PDOException $ex) {
            $error = $ex->getCode() === '23000' ? 'That Student ID already exists.' : 'Could not save the record. Check the database configuration.';
        }
    }
}
$pageTitle = 'Add Student';
require __DIR__ . '/header.php';
?>
<h1 class="h3 mb-3">Add Student</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<?php $actionLabel = 'Save Student'; require __DIR__ . '/student_form.php'; ?>
<?php require __DIR__ . '/footer.php'; ?>
