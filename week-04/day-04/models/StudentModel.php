<?php
// =============================================
// STUDENT MODEL - CRUD Operations
// =============================================

require_once __DIR__ . "/../config/database.php";

class StudentModel {
    private PDO $db;
    
    public function __construct() {
        $this->db = getConnection();
    }
    
    // Get all students with pagination and search
    public function getAll(string $search = "", int $page = 1, int $perPage = 10): array {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT s.*, d.name AS dept_name 
                FROM students s
                JOIN departments d ON s.department_id = d.id
                WHERE s.is_active = 1";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (s.first_name LIKE :search 
                      OR s.last_name LIKE :search 
                      OR s.email LIKE :search 
                      OR s.roll_number LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        $sql .= " ORDER BY s.last_name, s.first_name 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Count total students
    public function count(string $search = ""): int {
        $sql = "SELECT COUNT(*) FROM students WHERE is_active = 1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (first_name LIKE :search 
                      OR last_name LIKE :search 
                      OR email LIKE :search 
                      OR roll_number LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
    
    // Get student by ID
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT s.*, d.name AS dept_name 
             FROM students s
             JOIN departments d ON s.department_id = d.id
             WHERE s.id = :id AND s.is_active = 1"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    // Create new student
    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO students 
             (department_id, roll_number, first_name, last_name, email, phone, gpa, year_of_study)
             VALUES 
             (:dept_id, :roll, :first, :last, :email, :phone, :gpa, :year)"
        );
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }
    
    // Update student
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE students 
             SET department_id = :dept_id, 
                 roll_number = :roll, 
                 first_name = :first, 
                 last_name = :last, 
                 email = :email, 
                 phone = :phone, 
                 gpa = :gpa, 
                 year_of_study = :year
             WHERE id = :id AND is_active = 1"
        );
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    // Soft delete student
    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "UPDATE students SET is_active = 0 WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }
    
    // Get all departments (for dropdown)
    public function getDepartments(): array {
        $stmt = $this->db->query(
            "SELECT id, name, code FROM departments ORDER BY name"
        );
        return $stmt->fetchAll();
    }
}
?>