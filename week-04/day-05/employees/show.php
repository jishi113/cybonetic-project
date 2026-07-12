<?php
// =============================================
// VIEW EMPLOYEE DETAILS
// =============================================

require_once "../auth/middleware.php";
require_once "../models/EmployeeModel.php";

requireLogin();

$model = new EmployeeModel();
$id = (int) ($_GET['id'] ?? 0);
$employee = $model->getById($id);

if (!$employee) {
    header("Location: index.php?msg=not_found");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>👤 Employee Details</h1>
        
        <div class="card">
            <div class="card-body">
                <p><strong>Code:</strong> <?php echo htmlspecialchars($employee['employee_code']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($employee['full_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($employee['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($employee['phone'] ?? 'N/A'); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($employee['dept_name']); ?></p>
                <p><strong>Designation:</strong> <?php echo htmlspecialchars($employee['designation'] ?? 'N/A'); ?></p>
                <p><strong>Salary:</strong> ₹<?php echo number_format($employee['salary'], 2); ?></p>
                <p><strong>Joining Date:</strong> <?php echo htmlspecialchars($employee['joining_date']); ?></p>
                <p><strong>Status:</strong> <?php echo $employee['is_active'] ? '✅ Active' : '❌ Inactive'; ?></p>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
                <a href="edit.php?id=<?php echo $employee['id']; ?>" class="btn btn-warning">Edit</a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</body>
</html>