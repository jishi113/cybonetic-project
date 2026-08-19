<?php
// =============================================
// FRONT CONTROLLER - Routing
// =============================================

require_once "models/StudentModel.php";

$model = new StudentModel();
$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$msg = $_GET['msg'] ?? '';

// Get departments for dropdown
$departments = $model->getDepartments();

// Success/error messages
$messages = [
    'created' => '✅ Student created successfully!',
    'updated' => '✅ Student updated successfully!',
    'deleted' => '✅ Student deleted successfully!',
    'not_found' => '❌ Student not found!',
];

$message = $messages[$msg] ?? '';

switch ($action) {
    case 'index':
        $search = trim($_GET['search'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $students = $model->getAll($search, $page, 10);
        $totalStudents = $model->count($search);
        $totalPages = ceil($totalStudents / 10);
        require 'views/students/index.php';
        break;
        
    case 'create':
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'dept_id' => (int) $_POST['department_id'],
                'roll' => htmlspecialchars(trim($_POST['roll_number'])),
                'first' => htmlspecialchars(trim($_POST['first_name'])),
                'last' => htmlspecialchars(trim($_POST['last_name'])),
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'phone' => htmlspecialchars(trim($_POST['phone'] ?? '')),
                'gpa' => (float) $_POST['gpa'],
                'year' => (int) $_POST['year_of_study'],
            ];
            
            // Validation
            if (empty($data['first'])) $errors[] = "First name is required";
            if (empty($data['last'])) $errors[] = "Last name is required";
            if (empty($data['roll'])) $errors[] = "Roll number is required";
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Valid email is required";
            }
            if (empty($data['dept_id'])) $errors[] = "Please select a department";
            if ($data['gpa'] < 0 || $data['gpa'] > 10) {
                $errors[] = "GPA must be between 0 and 10";
            }
            if ($data['year'] < 1 || $data['year'] > 5) {
                $errors[] = "Year of study must be between 1 and 5";
            }
            
            if (empty($errors)) {
                $newId = $model->create($data);
                header("Location: index.php?action=show&id=$newId&msg=created");
                exit;
            }
        }
        require 'views/students/create.php';
        break;
        
    case 'edit':
        $student = $model->getById($id);
        if (!$student) {
            header("Location: index.php?msg=not_found");
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'dept_id' => (int) $_POST['department_id'],
                'roll' => htmlspecialchars(trim($_POST['roll_number'])),
                'first' => htmlspecialchars(trim($_POST['first_name'])),
                'last' => htmlspecialchars(trim($_POST['last_name'])),
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'phone' => htmlspecialchars(trim($_POST['phone'] ?? '')),
                'gpa' => (float) $_POST['gpa'],
                'year' => (int) $_POST['year_of_study'],
            ];
            
            if (empty($data['first'])) $errors[] = "First name is required";
            if (empty($data['last'])) $errors[] = "Last name is required";
            if (empty($data['roll'])) $errors[] = "Roll number is required";
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Valid email is required";
            }
            if (empty($data['dept_id'])) $errors[] = "Please select a department";
            if ($data['gpa'] < 0 || $data['gpa'] > 10) {
                $errors[] = "GPA must be between 0 and 10";
            }
            
            if (empty($errors)) {
                $model->update($id, $data);
                header("Location: index.php?action=show&id=$id&msg=updated");
                exit;
            }
        }
        require 'views/students/edit.php';
        break;
        
    case 'show':
        $student = $model->getById($id);
        if (!$student) {
            header("Location: index.php?msg=not_found");
            exit;
        }
        require 'views/students/show.php';
        break;
        
    case 'delete':
        if ($id && $model->delete($id)) {
            header("Location: index.php?msg=deleted");
        } else {
            header("Location: index.php?msg=not_found");
        }
        exit;
        
    default:
        header("Location: index.php");
        exit;
}
?>