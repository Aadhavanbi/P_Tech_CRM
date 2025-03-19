<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= esc($invoice['id']) ?></title>
</head>
<body style="font-family: Arial, sans-serif;font-size: 12px;margin: 0;">

<!-- <div style="width: 100%; border: 1px solid #ddd; "> -->
<div style="width: 100%; ">
    <table style="width: 100%;">
        <tr>
            <td>
                <h2>Invoice #<?= esc($invoice['id']) ?></h2>
                <p>Date Issued: <?= esc($invoice['created_at']) ?></p>
                <p>Due Date: <?= esc($invoice['due_date']) ?></p>
            </td>
            <td style="text-align: right;">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" style="max-width: 100px;">
                <p>Your Company Name</p>
                <p>your@email.com, +1234567890</p>
            </td>
        </tr>
    </table>

    <hr>

    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td>
                <h4>Issued For:</h4>
                <p>Name: <?= esc($invoice['client_name']) ?></p>
                <p>Address: <?= esc($invoice['client_address']) ?></p>
                <p>Phone: <?= esc($invoice['client_phone']) ?></p>
            </td>
            <td style="text-align: right;">
                <h4>Invoice Details:</h4>
                <p>Order ID: #<?= esc($invoice['id']) ?></p>
                <p>Shipment ID: <?= esc($invoice['shipment_id'] ?? 'N/A') ?></p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: #f8f8f8; border-bottom: 1px solid #ddd;">
                <th style="padding: 5px; border: 1px solid #ddd;">SL</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Item</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Qty</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Unit</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Unit Price</th>
                <th style="padding: 5px; border: 1px solid #ddd; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; $total = 0; ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td style="padding: 5px; border: 1px solid #ddd;"><?= $i++ ?></td>
                    <td style="padding: 5px; border: 1px solid #ddd;"><?= esc($item['item_name']) ?></td>
                    <td style="padding: 5px; border: 1px solid #ddd;"><?= esc($item['quantity']) ?></td>
                    <td style="padding: 5px; border: 1px solid #ddd;"><?= esc($item['unit']) ?></td>
                    <td style="padding: 5px; border: 1px solid #ddd;">$<?= esc(number_format($item['unit_price'], 2)) ?></td>
                    <td style="padding: 5px; border: 1px solid #ddd; text-align: right;">$<?= esc(number_format($item['total_price'], 2)) ?></td>
                </tr>
                <?php $total += $item['total_price']; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td>
                <p><strong>Sales By:</strong> <?= esc($invoice['sales_by'] ?? 'N/A') ?></p>
            </td>
            <td style="text-align: right;">
                <p>Subtotal: <strong>$<?= esc(number_format($total, 2)) ?></strong></p>
                <p>Tax: <strong>$<?= esc(number_format($invoice['tax'] ?? 0, 2)) ?></strong></p>
                <p>Discount: <strong>$<?= esc(number_format($invoice['discount'] ?? 0, 2)) ?></strong></p>
                <p><strong>Total: $<?= esc(number_format($total - ($invoice['discount'] ?? 0) + ($invoice['tax'] ?? 0), 2)) ?></strong></p>
            </td>
        </tr>
    </table>

    <hr>

    <p style="text-align: center;">Thank you for your business!</p>
</div>

</body>
</html>
