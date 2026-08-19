<?php


echo "<h1>📚 Week 4 - Day 3: MySQL Queries</h1>";

// Connect to MySQL
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=cybonetic_internship;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    echo "<p style='color:green'>✅ Connected to database successfully!</p>";
} catch (PDOException $e) {
    die("<p style='color:red'>❌ Connection failed: " . $e->getMessage() . "</p>");
}



echo "<h2>1. All Students with Department Names</h2>";

$stmt = $pdo->query("
    SELECT 
        s.id,
        s.roll_number,
        s.first_name,
        s.last_name,
        s.email,
        s.gpa,
        s.year_of_study,
        d.name AS department_name
    FROM students s
    INNER JOIN departments d ON s.department_id = d.id
    ORDER BY s.last_name
");

$students = $stmt->fetchAll();

echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
echo "<tr style='background:#2d3a5c;color:white;'>";
echo "<th>ID</th><th>Roll</th><th>Name</th><th>Email</th><th>GPA</th><th>Year</th><th>Department</th>";
echo "</tr>";

foreach ($students as $s) {
    echo "<tr>";
    echo "<td>{$s['id']}</td>";
    echo "<td>{$s['roll_number']}</td>";
    echo "<td>{$s['first_name']} {$s['last_name']}</td>";
    echo "<td>{$s['email']}</td>";
    echo "<td>{$s['gpa']}</td>";
    echo "<td>{$s['year_of_study']}</td>";
    echo "<td>{$s['department_name']}</td>";
    echo "</tr>";
}
echo "</table>";


echo "<h2>2. Department Statistics</h2>";

$stmt = $pdo->query("
    SELECT 
        d.name AS department_name,
        COUNT(s.id) AS total_students,
        ROUND(AVG(s.gpa), 2) AS avg_gpa,
        SUM(CASE WHEN s.gpa > 8.0 THEN 1 ELSE 0 END) AS students_above_8
    FROM departments d
    LEFT JOIN students s ON d.id = s.department_id AND s.is_active = 1
    GROUP BY d.id, d.name
    ORDER BY avg_gpa DESC
");

$depts = $stmt->fetchAll();

echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
echo "<tr style='background:#2d3a5c;color:white;'>";
echo "<th>Department</th><th>Total Students</th><th>Average GPA</th><th>Students > 8.0</th>";
echo "</tr>";

foreach ($depts as $d) {
    echo "<tr>";
    echo "<td>{$d['department_name']}</td>";
    echo "<td>{$d['total_students']}</td>";
    echo "<td>{$d['avg_gpa']}</td>";
    echo "<td>{$d['students_above_8']}</td>";
    echo "</tr>";
}
echo "</table>";



echo "<h2>3. Students with GPA Above Department Average</h2>";

$stmt = $pdo->query("
    SELECT 
        s.first_name,
        s.last_name,
        s.gpa,
        d.name AS department_name,
        (SELECT ROUND(AVG(s2.gpa), 2) FROM students s2 WHERE s2.department_id = s.department_id) AS dept_avg
    FROM students s
    INNER JOIN departments d ON s.department_id = d.id
    WHERE s.gpa > (
        SELECT AVG(s2.gpa) FROM students s2 WHERE s2.department_id = s.department_id
    )
    ORDER BY d.name, s.gpa DESC
");

$topStudents = $stmt->fetchAll();

echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
echo "<tr style='background:#2d3a5c;color:white;'>";
echo "<th>Name</th><th>GPA</th><th>Department</th><th>Dept Average</th>";
echo "</tr>";

foreach ($topStudents as $s) {
    echo "<tr>";
    echo "<td>{$s['first_name']} {$s['last_name']}</td>";
    echo "<td>{$s['gpa']}</td>";
    echo "<td>{$s['department_name']}</td>";
    echo "<td>{$s['dept_avg']}</td>";
    echo "</tr>";
}
echo "</table>";



echo "<h2>4. Students with Their Courses</h2>";

$stmt = $pdo->query("
    SELECT 
        s.first_name,
        s.last_name,
        sc.course_name,
        sc.grade,
        sc.semester
    FROM students s
    INNER JOIN student_courses sc ON s.id = sc.student_id
    ORDER BY s.last_name, sc.semester
");

$courses = $stmt->fetchAll();

echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
echo "<tr style='background:#2d3a5c;color:white;'>";
echo "<th>Student</th><th>Course</th><th>Grade</th><th>Semester</th>";
echo "</tr>";

foreach ($courses as $c) {
    echo "<tr>";
    echo "<td>{$c['first_name']} {$c['last_name']}</td>";
    echo "<td>{$c['course_name']}</td>";
    echo "<td>{$c['grade']}</td>";
    echo "<td>{$c['semester']}</td>";
    echo "</tr>";
}
echo "</table>";



echo "<h2>5. Top 3 Students by GPA in Each Department</h2>";

$stmt = $pdo->query("
    SELECT 
        first_name,
        last_name,
        gpa,
        department_name,
        rank_pos
    FROM (
        SELECT 
            s.first_name,
            s.last_name,
            s.gpa,
            d.name AS department_name,
            ROW_NUMBER() OVER (PARTITION BY s.department_id ORDER BY s.gpa DESC) AS rank_pos
        FROM students s
        INNER JOIN departments d ON s.department_id = d.id
        WHERE s.is_active = 1
    ) ranked
    WHERE rank_pos <= 3
    ORDER BY department_name, gpa DESC
");

$top3 = $stmt->fetchAll();

echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
echo "<tr style='background:#2d3a5c;color:white;'>";
echo "<th>Rank</th><th>Name</th><th>GPA</th><th>Department</th>";
echo "</tr>";

foreach ($top3 as $s) {
    echo "<tr>";
    echo "<td>#{$s['rank_pos']}</td>";
    echo "<td>{$s['first_name']} {$s['last_name']}</td>";
    echo "<td>{$s['gpa']}</td>";
    echo "<td>{$s['department_name']}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<hr>";
echo "<p>✅ All queries executed successfully!</p>";
?>