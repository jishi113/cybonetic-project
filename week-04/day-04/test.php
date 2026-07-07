<?php
require_once "config/database.php";

try {
    $pdo = getConnection();
    echo "<h1 style='color:green'>✅ Database connected successfully!</h1>";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM students");
    $count = $stmt->fetchColumn();
    echo "<p>Total students: <strong>$count</strong></p>";
    
} catch (PDOException $e) {
    echo "<h1 style='color:red'>❌ Error: " . $e->getMessage() . "</h1>";
}
?>