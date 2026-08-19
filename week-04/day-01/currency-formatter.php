<?php
function formatCurrency(float $amount, string $currency = 'INR'): string {
    $symbols = ['INR' => '₹', 'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'JPY' => '¥'];
    $symbol = $symbols[$currency] ?? $currency;
    return $symbol . number_format($amount, 2, '.', ',');
}

$testAmounts = [12345.67, 999.99, 1000000, 0.99, 1234567.89, 50.5, 1, -500, -1234.56];
$currencies = ['INR', 'USD', 'EUR', 'GBP', 'JPY'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Currency Formatter</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 700px; width: 100%; }
        h1 { color: #2d3a5c; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #2d3a5c; color: white; padding: 12px; text-align: center; }
        td { padding: 10px 12px; border-bottom: 1px solid #eee; text-align: center; }
        td:first-child { text-align: left; font-weight: 500; }
        tr:hover td { background: #f8f9fa; }
        .negative { color: #e85555; }
    </style>
</head>
<body>
    <div class="container">
        <h1>💰 Currency Formatter</h1>
        <table>
            <tr>
                <th>Amount</th>
                <?php foreach ($currencies as $c): ?>
                    <th><?php echo $c; ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($testAmounts as $amount): ?>
                <tr>
                    <td><?php echo $amount; ?></td>
                    <?php foreach ($currencies as $currency): ?>
                        <td class="<?php echo $amount < 0 ? 'negative' : ''; ?>">
                            <?php echo formatCurrency($amount, $currency); ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>