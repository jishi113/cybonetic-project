<?php
// Random quotes
$quotes = [
    "The only way to do great work is to love what you do. - Steve Jobs",
    "In the middle of difficulty lies opportunity. - Albert Einstein",
    "Success is not final, failure is not fatal. - Winston Churchill",
    "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt",
    "It does not matter how slowly you go as long as you do not stop. - Confucius"
];

$randomQuote = $quotes[array_rand($quotes)];
$visitorIP = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$todayDate = date('l, F j, Y');
$currentTime = date('h:i:s A');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Week 4 - Day 1</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 600px; width: 100%; text-align: center; }
        h1 { color: #2d3a5c; }
        .box { background: #f8f9fa; padding: 20px; border-radius: 12px; margin: 15px 0; }
        .box .label { font-size: 12px; color: #888; text-transform: uppercase; }
        .box .value { font-size: 20px; color: #2d3a5c; font-weight: 600; margin-top: 4px; }
        .quote { background: #e8f0fe; padding: 20px; border-radius: 12px; border-left: 4px solid #0055ee; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Welcome to PHP</h1>
        <div class="box">
            <div class="label">📅 Today's Date</div>
            <div class="value"><?php echo $todayDate; ?></div>
        </div>
        <div class="box">
            <div class="label">🕐 Current Time</div>
            <div class="value"><?php echo $currentTime; ?></div>
        </div>
        <div class="quote">"<?php echo $randomQuote; ?>"</div>
        <div class="box">
            <div class="label">🌐 Your IP Address</div>
            <div class="value"><?php echo $visitorIP; ?></div>
        </div>
    </div>
</body>
</html>