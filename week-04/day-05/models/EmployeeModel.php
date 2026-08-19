<?php
// =============================================
// EMPLOYEE MODEL - CRUD Operations
// =============================================

require_once __DIR__ . "/../config/database.php";

class EmployeeModel {
    private PDO $db;
    
    public function __construct() {
        $this->db = getConnection();
    }
    
    public function getAll(string $search = "", int $departmentId = 0): array {
        $sql = "SELECT e.*, d.name AS dept_name 
                FROM employees e
                JOIN departments d ON e.department_id = d.id
                WHERE e.is_active = 1";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (e.full_name LIKE :search 
                      OR e.email LIKE :search 
                      OR e.employee_code LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        if ($departmentId > 0) {
            $sql .= " AND e.department_id = :dept_id";
            $params['dept_id'] = $departmentId;
        }
        
        $sql .= " ORDER BY e.full_name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT e.*, d.name AS dept_name 
             FROM employees e
             JOIN departments d ON e.department_id = d.id
             WHERE e.id = :id AND e.is_active = 1"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO employees 
             (department_id, employee_code, full_name, email, phone, designation, salary, joining_date)
             VALUES 
             (:dept_id, :code, :name, :email, :phone, :designation, :salary, :joining_date)"
        );
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }
    
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE employees 
             SET department_id = :dept_id, 
                 employee_code = :code, 
                 full_name = :name, 
                 email = :email, 
                 phone = :phone, 
                 designation = :designation, 
                 salary = :salary, 
                 joining_date = :joining_date
             WHERE id = :id AND is_active = 1"
        );
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "UPDATE employees SET is_active = 0 WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }
    
    public function getDepartments(): array {
        $stmt = $this->db->query(
            "SELECT id, name, code FROM departments ORDER BY name"
        );
        return $stmt->fetchAll();
    }
}
?>