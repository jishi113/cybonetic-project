<?php
// =============================================
// EMPLOYEE LIST - Protected
// =============================================

require_once "../auth/middleware.php";
require_once "../models/EmployeeModel.php";

requireLogin();

$model = new EmployeeModel();
$search = trim($_GET['search'] ?? '');
$departmentId = (int) ($_GET['department_id'] ?? 0);

$employees = $model->getAll($search, $departmentId);
$departments = $model->getDepartments();
$message = $_GET['msg'] ?? '';

$messages = [
    'created' => '✅ Employee created successfully!',
    'updated' => '✅ Employee updated successfully!',
    'deleted' => '✅ Employee deleted successfully!',
];
$msgText = $messages[$message] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees - Employee Directory</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>👥 Employees</h1>
            <div>
                <span style="margin-right: 15px;">👋 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="../dashboard.php" class="btn btn-secondary">Dashboard</a>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        
        <?php if ($msgText): ?>
            <div class="alert alert-success"><?php echo $msgText; ?></div>
        <?php endif; ?>
        
        <div class="actions">
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
                <a href="create.php" class="btn btn-primary">+ Add Employee</a>
            <?php endif; ?>
            
            <form method="GET" class="search-form">
                <select name="department_id">
                    <option value="0">All Departments</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?php echo $dept['id']; ?>" 
                            <?php echo ($departmentId == $dept['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dept['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($employees)): ?>
                    <tr><td colspan="7" style="text-align:center; padding: 20px;">No employees found</td></tr>
                <?php else: ?>
                    <?php foreach ($employees as $e): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($e['employee_code']); ?></td>
                            <td><?php echo htmlspecialchars($e['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($e['email']); ?></td>
                            <td><?php echo htmlspecialchars($e['dept_name']); ?></td>
                            <td><?php echo htmlspecialchars($e['designation']); ?></td>
                            <td>₹<?php echo number_format($e['salary'], 2); ?></td>
                            <td>
                                <a href="show.php?id=<?php echo $e['id']; ?>" class="btn btn-sm btn-info">View</a>
                                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
                                    <a href="edit.php?id=<?php echo $e['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <?php endif; ?>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <a href="delete.php?id=<?php echo $e['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure?')">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>