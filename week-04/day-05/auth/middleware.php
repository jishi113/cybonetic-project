<?php
// =============================================
// AUTHENTICATION MIDDLEWARE
// =============================================

function ensureSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function requireLogin(): void {
    ensureSession();
    
    if (empty($_SESSION['logged_in'])) {
        $returnTo = urlencode($_SERVER['REQUEST_URI']);
        header("Location: login.php?returnTo=$returnTo");
        exit;
    }
}

function requireRole(string ...$roles): void {
    requireLogin();
    
    $userRole = $_SESSION['role'] ?? '';
    if (!in_array($userRole, $roles, true)) {
        header("HTTP/1.1 403 Forbidden");
        die("Access denied. Need: " . implode(', ', $roles));
    }
}

function generateCsrfToken(): string {
    ensureSession();
    
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrf(): void {
    ensureSession();
    
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        header("HTTP/1.1 403 Forbidden");
        die("CSRF validation failed.");
    }
}

function logoutUser(): void {
    ensureSession();
    
    $_SESSION = [];
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
}
?>