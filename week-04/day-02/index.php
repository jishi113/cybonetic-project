<?php
// =============================================
// WEEK 4 - DAY 2: OOP PHP
// =============================================

require_once 'Database.php';
require_once 'Student.php';
require_once 'Repository.php';
require_once 'Validator.php';

echo "<h1>📚 Week 4 - Day 2: Object-Oriented PHP</h1>";

// =============================================
// 1. TEST STUDENT CLASS
// =============================================

echo "<h2>1. Student Class</h2>";

$student1 = new Student(1, "Jishi", "jishi@example.com", 8.9);
$student2 = new Student(2, "Priya", "priya@example.com", 9.1);

echo "<p><strong>Student 1:</strong> " . $student1 . "</p>";
echo "<p><strong>Student 2:</strong> " . $student2 . "</p>";
echo "<p><strong>Total Students:</strong> " . Student::getCount() . "</p>";

// =============================================
// 2. TEST STUDENT FROM ARRAY (Factory Method)
// =============================================

echo "<h2>2. Student from Array (Factory Method)</h2>";

$data = [
    'id' => 3,
    'name' => 'Rahul',
    'email' => 'rahul@example.com',
    'gpa' => 7.5
];

$student3 = Student::fromArray($data);
echo "<p><strong>Student 3:</strong> " . $student3 . "</p>";

// =============================================
// 3. TEST GRADUATE STUDENT (Inheritance)
// =============================================

echo "<h2>3. Graduate Student (Inheritance)</h2>";

$grad = new GraduateStudent(
    4, 
    "Sneha", 
    "sneha@example.com", 
    9.5,
    "AI Ethics",
    "Dr. Kumar"
);

echo "<p><strong>Graduate Student:</strong> " . $grad . "</p>";
echo "<p><strong>Grade:</strong> " . $grad->getGrade() . "</p>";

// =============================================
// 4. TEST REPOSITORY
// =============================================

echo "<h2>4. Repository Pattern</h2>";

$repo = new StudentRepository();
echo "<p>Repository created successfully!</p>";

$allStudents = $repo->findAll();
echo "<p>All Students:</p>";
echo "<pre>";
print_r($allStudents);
echo "</pre>";

// =============================================
// 5. TEST VALIDATOR TRAIT
// =============================================

echo "<h2>5. Validator Trait</h2>";

$testData = [
    'email' => 'jishi@example.com',
    'phone' => '9876543210',
    'name' => 'Ji',
    'password' => 'pass'
];

$validator = new ValidatorTest();
echo "<p>Email valid: " . ($validator->isEmail($testData['email']) ? '✅ Yes' : '❌ No') . "</p>";
echo "<p>Phone valid: " . ($validator->isPhone($testData['phone']) ? '✅ Yes' : '❌ No') . "</p>";
echo "<p>Name min length (3): " . ($validator->minLength($testData['name'], 3) ? '✅ Yes' : '❌ No') . "</p>";
echo "<p>Password min length (8): " . ($validator->minLength($testData['password'], 8) ? '✅ Yes' : '❌ No') . "</p>";

// =============================================
// 6. TEST DATABASE SINGLETON
// =============================================

echo "<h2>6. Database Singleton</h2>";

$db1 = Database::getInstance();
$db2 = Database::getInstance();

if ($db1 === $db2) {
    echo "<p>✅ Both instances are the same! Singleton working!</p>";
} else {
    echo "<p>❌ Singleton failed!</p>";
}

echo "<p>Database connection status: " . ($db1->isConnected() ? '✅ Connected' : '❌ Not connected (MySQL not running)') . "</p>";

echo "<hr>";
echo "<p>✅ All Day 2 exercises completed!</p>";
?>