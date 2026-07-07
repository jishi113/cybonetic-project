<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="container">
        <h1>✏️ Edit Student</h1>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p>❌ <?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Roll Number *</label>
                <input type="text" name="roll_number" 
                       value="<?php echo isset($student) ? htmlspecialchars($student['roll_number']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" name="first_name" 
                       value="<?php echo isset($student) ? htmlspecialchars($student['first_name']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label>Last Name *</label>
                <input type="text" name="last_name" 
                       value="<?php echo isset($student) ? htmlspecialchars($student['last_name']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" 
                       value="<?php echo isset($student) ? htmlspecialchars($student['email']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" 
                       value="<?php echo isset($student) ? htmlspecialchars($student['phone'] ?? '') : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Department *</label>
                <select name="department_id" required>
                    <option value="">-- Select Department --</option>
                    <?php if (isset($departments) && !empty($departments)): ?>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?php echo $dept['id']; ?>" 
                                <?php echo (isset($student) && $student['department_id'] == $dept['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($dept['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No departments found</option>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>GPA (0-10) *</label>
                <input type="number" name="gpa" step="0.01" min="0" max="10" 
                       value="<?php echo isset($student) ? htmlspecialchars($student['gpa']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label>Year of Study *</label>
                <input type="number" name="year_of_study" min="1" max="5" 
                       value="<?php echo isset($student) ? htmlspecialchars($student['year_of_study']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Update Student</button>
                <a href="index.php" class="btn btn-secondary">❌ Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>