<?php
require_once __DIR__ . '/includes.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method not allowed.'); }
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt = db()->prepare('DELETE FROM students WHERE id = ?');
    $stmt->execute([$id]);
    flash('success', 'Student record deleted.');
}
header('Location: students.php');
exit;
