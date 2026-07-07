<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="container">
        <h1>📚 Student Management System</h1>
        
        <?php if (isset($message) && !empty($message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="actions">
            <a href="?action=create" class="btn btn-primary">+ Add Student</a>
            <form method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search students..." 
                       value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>GPA</th>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px;">No students found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($students as $s): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($s['roll_number'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars(($s['first_name'] ?? '') . ' ' . ($s['last_name'] ?? '')); ?></td>
                            <td><?php echo htmlspecialchars($s['email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($s['dept_name'] ?? ''); ?></td>
                            <td><?php echo isset($s['gpa']) ? number_format($s['gpa'], 2) : ''; ?></td>
                            <td><?php echo $s['year_of_study'] ?? ''; ?></td>
                            <td>
                                <a href="?action=show&id=<?php echo $s['id']; ?>" class="btn btn-sm btn-info">View</a>
                                <a href="?action=edit&id=<?php echo $s['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?action=delete&id=<?php echo $s['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&search=<?php echo isset($search) ? urlencode($search) : ''; ?>" 
                       class="<?php echo ($i == ($page ?? 1)) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>