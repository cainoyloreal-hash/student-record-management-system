<?php
$student = $student ?? ['student_no'=>'','first_name'=>'','last_name'=>'','gender'=>'','course'=>'','year_level'=>'','email'=>'','contact_no'=>''];
$actionLabel = $actionLabel ?? 'Save Student';
?>
<form method="post" class="card border-0 shadow-sm"><div class="card-body p-4">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="row g-3">
 <div class="col-md-6"><label class="form-label">Student ID *</label><input class="form-control" name="student_no" maxlength="30" required value="<?= e($student['student_no']) ?>"></div>
 <div class="col-md-6"><label class="form-label">Gender</label><select class="form-select" name="gender"><option value="">Select</option><?php foreach (['Female','Male','Prefer not to say'] as $g): ?><option value="<?= e($g) ?>" <?= $student['gender']===$g?'selected':'' ?>><?= e($g) ?></option><?php endforeach; ?></select></div>
 <div class="col-md-6"><label class="form-label">First Name *</label><input class="form-control" name="first_name" maxlength="80" required value="<?= e($student['first_name']) ?>"></div>
 <div class="col-md-6"><label class="form-label">Last Name *</label><input class="form-control" name="last_name" maxlength="80" required value="<?= e($student['last_name']) ?>"></div>
 <div class="col-md-6"><label class="form-label">Course *</label><input class="form-control" name="course" maxlength="100" required placeholder="e.g. BS Information Technology" value="<?= e($student['course']) ?>"></div>
 <div class="col-md-6"><label class="form-label">Year Level *</label><select class="form-select" name="year_level" required><option value="">Select year</option><?php foreach (['1st Year','2nd Year','3rd Year','4th Year','5th Year'] as $y): ?><option value="<?= e($y) ?>" <?= $student['year_level']===$y?'selected':'' ?>><?= e($y) ?></option><?php endforeach; ?></select></div>
 <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" maxlength="120" value="<?= e($student['email']) ?>"></div>
 <div class="col-md-6"><label class="form-label">Contact Number</label><input class="form-control" name="contact_no" maxlength="30" value="<?= e($student['contact_no']) ?>"></div>
</div>
<div class="d-flex gap-2 mt-4"><button class="btn btn-primary"><?= e($actionLabel) ?></button><a class="btn btn-outline-secondary" href="students.php">Cancel</a></div>
</div></form>
