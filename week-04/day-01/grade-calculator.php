<?php
function calculateGrade(int $score): string {
    return match(true) {
        $score >= 90 => 'A (Distinction)',
        $score >= 80 => 'B (First Class)',
        $score >= 70 => 'C (Second Class)',
        $score >= 60 => 'D (Pass)',
        default => 'F (Fail)',
    };
}

$submitted = $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['score']);
$score = $submitted ? (int)$_GET['score'] : null;
$grade = $submitted ? calculateGrade($score) : null;
$error = $submitted && ($score < 0 || $score > 100);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Grade Calculator</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 500px; width: 100%; text-align: center; }
        h1 { color: #2d3a5c; }
        input { padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 16px; width: 100%; margin: 10px 0; }
        button { padding: 12px; background: #0055ee; color: white; border: none; border-radius: 10px; font-size: 16px; cursor: pointer; width: 100%; }
        button:hover { background: #0044cc; }
        .result { margin-top: 20px; padding: 20px; border-radius: 12px; }
        .result .score { font-size: 48px; font-weight: 700; }
        .result .grade { font-size: 24px; font-weight: 600; }
        .pass { background: #e8f8f2; color: #00c896; }
        .fail { background: #fde8e8; color: #e85555; }
        .error { background: #fde8e8; color: #e85555; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Grade Calculator</h1>
        <form method="GET">
            <input type="number" name="score" min="0" max="100" placeholder="Enter score (0-100)" required>
            <button type="submit">Calculate Grade</button>
        </form>
        <?php if ($submitted): ?>
            <?php if ($error): ?>
                <div class="result error">❌ Please enter a score between 0 and 100</div>
            <?php else: ?>
                <div class="result <?php echo $score >= 60 ? 'pass' : 'fail'; ?>">
                    <div class="score"><?php echo $score; ?></div>
                    <div class="grade"><?php echo $grade; ?></div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>