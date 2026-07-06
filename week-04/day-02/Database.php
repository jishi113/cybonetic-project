<?php
// =============================================
// DATABASE SINGLETON CLASS
// =============================================

class Database {
    private static ?Database $instance = null;
    private ?PDO $connection = null;
    private bool $connected = false;

    // Private constructor (singleton pattern)
    private function __construct() {
        // Try to connect to MySQL (optional for now)
        try {
            // Check if PDO extension is available
            if (!class_exists('PDO')) {
                $this->connected = false;
                return;
            }
            
            $this->connection = new PDO(
                'mysql:host=localhost;dbname=test;charset=utf8mb4',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            $this->connected = true;
        } catch (PDOException $e) {
            $this->connected = false;
            // Don't crash - we'll handle this gracefully
        }
    }

    // Get the single instance
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get the PDO connection
    public function getConnection(): ?PDO {
        return $this->connection;
    }

    // Check if connected
    public function isConnected(): bool {
        return $this->connected;
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialization
    public function __wakeup() {}
}
?>