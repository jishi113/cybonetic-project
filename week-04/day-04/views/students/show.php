<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="container">
        <h1>👤 Student Details</h1>

        <?php if (isset($message) && !empty($message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> <?php echo isset($student) ? $student['id'] : ''; ?></p>
                <p><strong>Roll Number:</strong> <?php echo isset($student) ? $student['roll_number'] : ''; ?></p>
                <p><strong>Name:</strong> <?php echo isset($student) ? ($student['first_name'] . ' ' . $student['last_name']) : ''; ?></p>
                <p><strong>Email:</strong> <?php echo isset($student) ? $student['email'] : ''; ?></p>
                <p><strong>Phone:</strong> <?php echo isset($student) ? ($student['phone'] ?? 'N/A') : 'N/A'; ?></p>
                <p><strong>Department:</strong> <?php echo isset($student) ? $student['dept_name'] : 'N/A'; ?></p>
                <p><strong>GPA:</strong> <?php echo isset($student) ? number_format($student['gpa'], 2) : 'N/A'; ?></p>
                <p><strong>Year of Study:</strong> <?php echo isset($student) ? $student['year_of_study'] : 'N/A'; ?></p>
                <p><strong>Status:</strong> 
                    <?php echo (isset($student) && $student['is_active'] == 1) ? '✅ Active' : '❌ Inactive'; ?>
                </p>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <a href="?action=edit&id=<?php echo isset($student) ? $student['id'] : ''; ?>" class="btn btn-warning">✏️ Edit</a>
            <a href="?action=delete&id=<?php echo isset($student) ? $student['id'] : ''; ?>" 
               class="btn btn-danger"
               onclick="return confirm('Delete this student?')">🗑️ Delete</a>
            <a href="index.php" class="btn btn-secondary">⬅️ Back</a>
        </div>
    </div>
</body>
</html>