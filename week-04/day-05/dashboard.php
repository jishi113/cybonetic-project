<?php
// =============================================
// DASHBOARD - Protected Page
// =============================================

require_once "auth/middleware.php";
requireLogin();

$username = $_SESSION['username'] ?? 'User';
$role = $_SESSION['role'] ?? 'viewer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Employee Directory</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>🏢 Employee Directory</h1>
            <div>
                <span style="margin-right: 15px;">👋 Welcome, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role); ?>)</span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px;">
            <div class="card" style="text-align: center;">
                <h2>👥 Employees</h2>
                <a href="employees/index.php" class="btn btn-primary">Manage Employees</a>
            </div>
            
            <?php if ($role === 'admin' || $role === 'manager'): ?>
                <div class="card" style="text-align: center;">
                    <h2>➕ Add Employee</h2>
                    <a href="employees/create.php" class="btn btn-success">Add New Employee</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>