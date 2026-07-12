<?php
// =============================================
// LOGIN PAGE
// =============================================

require_once "auth/middleware.php";
require_once "models/UserModel.php";

ensureSession();

if (!empty($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        $user = $userModel->getByUsername($username);
        
        $hash = $user['password_hash'] ?? password_hash('dummy', PASSWORD_DEFAULT);
        
        if ($user && $userModel->verifyPassword($password, $hash)) {
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            $userModel->updateLastLogin($user['id']);
            
            $returnTo = $_POST['returnTo'] ?? 'dashboard.php';
            header("Location: " . filter_var($returnTo, FILTER_SANITIZE_URL));
            exit;
        } else {
            sleep(1);
            $error = "Invalid username or password.";
        }
    }
}

$csrfToken = generateCsrfToken();
$returnTo = $_GET['returnTo'] ?? 'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Directory</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <h1 style="text-align: center;">🔐 Login</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="returnTo" value="<?php echo htmlspecialchars($returnTo); ?>">
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </form>
        
        <p style="text-align: center; margin-top: 20px; color: #888; font-size: 14px;">
            Default: admin / Admin@123!
        </p>
    </div>
</body>
</html>