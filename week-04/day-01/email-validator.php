<?php
function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

$testEmails = [
    'jishi@example.com',
    'user.name@gmail.com',
    'invalid-email',
    'missing@domain',
    'user@domain',
    'user@domain.com',
    'user@sub.domain.co.in',
    'user.name+filter@gmail.com',
    'user@domain..com',
    'user@domain.c'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Validator</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 700px; width: 100%; }
        h1 { color: #2d3a5c; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #2d3a5c; color: white; padding: 12px; text-align: left; }
        td { padding: 10px 12px; border-bottom: 1px solid #eee; }
        tr:hover td { background: #f8f9fa; }
        .valid { background: #00c896; color: white; padding: 2px 12px; border-radius: 20px; font-size: 12px; }
        .invalid { background: #e85555; color: white; padding: 2px 12px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Email Validator</h1>
        <table>
            <tr><th>#</th><th>Email</th><th>Status</th></tr>
            <?php foreach ($testEmails as $index => $email): ?>
                <?php $isValid = validateEmail($email); ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($email); ?></td>
                    <td>
                        <?php if ($isValid): ?>
                            <span class="valid">✅ Valid</span>
                        <?php else: ?>
                            <span class="invalid">❌ Invalid</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>