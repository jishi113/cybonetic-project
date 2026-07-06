<?php
// =============================================
// REPOSITORY INTERFACE AND IMPLEMENTATION
// =============================================

// Interface - Contract for all repositories
interface Repository {
    public function findAll(): array;
    public function findById(int $id): ?array;
    public function create(array $data): bool;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}

// Student Repository - implements the interface
class StudentRepository implements Repository {
    private array $students = [];

    public function __construct() {
        // Sample data
        $this->students = [
            1 => ['id' => 1, 'name' => 'Jishi', 'email' => 'jishi@example.com', 'gpa' => 8.9],
            2 => ['id' => 2, 'name' => 'Priya', 'email' => 'priya@example.com', 'gpa' => 9.1],
        ];
    }

    public function findAll(): array {
        return $this->students;
    }

    public function findById(int $id): ?array {
        return $this->students[$id] ?? null;
    }

    public function create(array $data): bool {
        $id = count($this->students) + 1;
        $data['id'] = $id;
        $this->students[$id] = $data;
        return true;
    }

    public function update(int $id, array $data): bool {
        if (!isset($this->students[$id])) {
            return false;
        }
        $this->students[$id] = array_merge($this->students[$id], $data);
        return true;
    }

    public function delete(int $id): bool {
        if (!isset($this->students[$id])) {
            return false;
        }
        unset($this->students[$id]);
        return true;
    }
}
?>