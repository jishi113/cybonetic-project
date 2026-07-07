-- Step 1: Create Database
CREATE DATABASE IF NOT EXISTS cybonetic_internship
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE cybonetic_internship;

-- Step 2: Create Departments Table
CREATE TABLE departments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    code VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Step 3: Create Students Table
CREATE TABLE students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    department_id INT UNSIGNED NOT NULL,
    roll_number VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(15),
    gpa DECIMAL(3,2) CHECK (gpa >= 0.0 AND gpa <= 10.0),
    year_of_study TINYINT CHECK (year_of_study BETWEEN 1 AND 5),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Step 4: Create Student Courses Table
CREATE TABLE student_courses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    grade VARCHAR(2),
    semester TINYINT CHECK (semester BETWEEN 1 AND 8),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Step 5: Insert Sample Departments
INSERT INTO departments (name, code) VALUES
('Computer Science', 'CS'),
('Information Technology', 'IT'),
('Electronics', 'EC'),
('Mechanical', 'ME');

-- Step 6: Insert Sample Students
INSERT INTO students (department_id, roll_number, first_name, last_name, email, phone, gpa, year_of_study) VALUES
(1, 'CS2026001', 'Jishi', 'Kumar', 'jishi@example.com', '9876543210', 8.9, 3),
(1, 'CS2026002', 'Priya', 'Sharma', 'priya@example.com', '9876543211', 9.1, 3),
(1, 'CS2026003', 'Rahul', 'Verma', 'rahul@example.com', '9876543212', 7.5, 2),
(2, 'IT2026001', 'Sneha', 'Patel', 'sneha@example.com', '9876543213', 8.5, 3),
(2, 'IT2026002', 'Arjun', 'Singh', 'arjun@example.com', '9876543214', 6.8, 2),
(2, 'IT2026003', 'Kavya', 'Reddy', 'kavya@example.com', '9876543215', 9.2, 4),
(3, 'EC2026001', 'Vikram', 'Rao', 'vikram@example.com', '9876543216', 7.8, 3),
(3, 'EC2026002', 'Anjali', 'Menon', 'anjali@example.com', '9876543217', 8.2, 2),
(3, 'EC2026003', 'Rohan', 'Gupta', 'rohan@example.com', '9876543218', 6.5, 1),
(4, 'ME2026001', 'Meera', 'Nair', 'meera@example.com', '9876543219', 9.0, 4),
(4, 'ME2026002', 'Karan', 'Joshi', 'karan@example.com', '9876543220', 7.2, 3),
(4, 'ME2026003', 'Divya', 'Kaur', 'divya@example.com', '9876543221', 8.7, 2);

-- Step 7: Insert Sample Student Courses
INSERT INTO student_courses (student_id, course_name, grade, semester) VALUES
(1, 'Data Structures', 'A', 3),
(1, 'Database Systems', 'A', 3),
(1, 'Operating Systems', 'B+', 3),
(2, 'Data Structures', 'A', 3),
(2, 'Database Systems', 'A+', 3),
(2, 'Operating Systems', 'A', 3),
(3, 'Data Structures', 'B', 2),
(3, 'Database Systems', 'C+', 2),
(4, 'Network Security', 'A', 3),
(4, 'Web Technologies', 'A-', 3),
(5, 'Network Security', 'B', 2),
(5, 'Web Technologies', 'C+', 2),
(6, 'Network Security', 'A+', 4),
(6, 'Web Technologies', 'A', 4);

-- Step 8: Create Indexes for Performance
CREATE INDEX idx_students_dept ON students(department_id);
CREATE INDEX idx_students_name ON students(last_name, first_name);
CREATE INDEX idx_students_gpa ON students(gpa);
CREATE INDEX idx_courses_student ON student_courses(student_id);

-- Step 9: View All Data (Sample Queries)
-- Show all departments
SELECT * FROM departments;

-- Show all students with department names
SELECT 
    s.id,
    s.roll_number,
    s.first_name,
    s.last_name,
    s.email,
    s.gpa,
    s.year_of_study,
    d.name AS department_name,
    d.code AS department_code
FROM students s
INNER JOIN departments d ON s.department_id = d.id;

-- Show all students with their courses
SELECT 
    s.first_name,
    s.last_name,
    sc.course_name,
    sc.grade,
    sc.semester
FROM students s
INNER JOIN student_courses sc ON s.id = sc.student_id
ORDER BY s.last_name, sc.semester;

-- Department-wise student count and average GPA
SELECT 
    d.name AS department_name,
    COUNT(s.id) AS total_students,
    ROUND(AVG(s.gpa), 2) AS avg_gpa,
    SUM(CASE WHEN s.gpa > 8.0 THEN 1 ELSE 0 END) AS students_above_8
FROM departments d
LEFT JOIN students s ON d.id = s.department_id AND s.is_active = 1
GROUP BY d.id, d.name
ORDER BY avg_gpa DESC;

-- Students with GPA above their department's average (Correlated Subquery)
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
ORDER BY d.name, s.gpa DESC;

-- Show departments with no students (using LEFT JOIN)
SELECT 
    d.name AS department_name,
    COUNT(s.id) AS student_count
FROM departments d
LEFT JOIN students s ON d.id = s.department_id
GROUP BY d.id, d.name
HAVING student_count = 0;

-- Show grade distribution (count of each grade)
SELECT 
    grade,
    COUNT(*) AS count
FROM student_courses
GROUP BY grade
ORDER BY grade;

-- Find top 3 students by GPA in each department (using window functions)
SELECT 
    first_name,
    last_name,
    gpa,
    department_name
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
ORDER BY department_name, gpa DESC;

