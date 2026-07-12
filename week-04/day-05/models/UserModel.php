<?php
// =============================================
// USER MODEL - Authentication
// =============================================

require_once __DIR__ . "/../config/database.php";

class UserModel {
    private PDO $db;
    
    public function __construct() {
        $this->db = getConnection();
    }
    
    public function getByUsername(string $username): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE username = :username AND is_active = 1"
        );
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }
    
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT id, username, email, role, is_active, last_login, created_at 
             FROM users WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function updateLastLogin(int $id): void {
        $stmt = $this->db->prepare(
            "UPDATE users SET last_login = NOW() WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
    }
    
    public function verifyPassword(string $input, string $hash): bool {
        return password_verify($input, $hash);
    }
}
?>