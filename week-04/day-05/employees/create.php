<?php
// =============================================
// CREATE EMPLOYEE - Admin/Manager Only
// =============================================

require_once "../auth/middleware.php";
require_once "../models/EmployeeModel.php";

requireRole('admin', 'manager');

$model = new EmployeeModel();
$departments = $model->getDepartments();
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();
    
    $data = [
        'dept_id' => (int) $_POST['department_id'],
        'code' => htmlspecialchars(trim($_POST['employee_code'])),
        'name' => htmlspecialchars(trim($_POST['full_name'])),
        'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
        'phone' => htmlspecialchars(trim($_POST['phone'] ?? '')),
        'designation' => htmlspecialchars(trim($_POST['designation'] ?? '')),
        'salary' => (float) $_POST['salary'],
        'joining_date' => $_POST['joining_date'],
    ];
    
    if (empty($data['code'])) $errors[] = "Employee code is required";
    if (empty($data['name'])) $errors[] = "Full name is required";
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    if (empty($data['dept_id'])) $errors[] = "Department is required";
    if (empty($data['joining_date'])) $errors[] = "Joining date is required";
    
    if (empty($errors)) {
        $id = $model->create($data);
        header("Location: index.php?msg=created");
        exit;
    }
}

$csrfToken = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>➕ Add Employee</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $e): ?>
                    <p>❌ <?php echo htmlspecialchars($e); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            
            <div class="form-group">
                <label>Employee Code *</label>
                <input type="text" name="employee_code" value="<?php echo htmlspecialchars($data['code'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($data['name'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label>Department *</label>
                <select name="department_id" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?php echo $dept['id']; ?>" 
                            <?php echo (($data['dept_id'] ?? 0) == $dept['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dept['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Designation</label>
                <input type="text" name="designation" value="<?php echo htmlspecialchars($data['designation'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label>Salary (₹)</label>
                <input type="number" name="salary" step="0.01" value="<?php echo htmlspecialchars($data['salary'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label>Joining Date *</label>
                <input type="date" name="joining_date" value="<?php echo htmlspecialchars($data['joining_date'] ?? ''); ?>" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Employee</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>