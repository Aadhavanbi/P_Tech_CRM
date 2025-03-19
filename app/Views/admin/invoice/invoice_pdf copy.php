<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= esc($invoice['id']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; margin: 20px; }
        .container { width: 100%; max-width: 800px; margin: auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 150px; }
        .invoice-details { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .invoice-details th, .invoice-details td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .invoice-summary { width: 100%; text-align: right; }
        .invoice-summary td { padding: 8px; }
        .footer { text-align: center; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Company Logo">
            <h2>Invoice #<?= esc($invoice['id']) ?></h2>
            <p><strong>Date Issued:</strong> <?= esc($invoice['invoice_date']) ?></p>
            <p><strong>Due Date:</strong> <?= esc($invoice['due_date']) ?></p>
        </div>

        <h3>Client Details</h3>
        <p><strong>Name:</strong> <?= esc($client['name']) ?></p>
        <p><strong>Email:</strong> <?= esc($client['email']) ?></p>
        <p><strong>Phone:</strong> <?= esc($client['phone']) ?></p>
        <p><strong>Address:</strong> <?= esc($client['address']) ?></p>

        <h3>Invoice Items</h3>
        <table class="invoice-details">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; $total = 0; ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($item['item_name']) ?></td>
                        <td><?= esc($item['quantity']) ?></td>
                        <td>$<?= esc(number_format($item['unit_price'], 2)) ?></td>
                        <td>$<?= esc(number_format($item['total_price'], 2)) ?></td>
                    </tr>
                    <?php $total += $item['total_price']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table class="invoice-summary">
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>$<?= esc(number_format($total, 2)) ?></td>
            </tr>
            <tr>
                <td><strong>Tax (10%):</strong></td>
                <td>$<?= esc(number_format($total * 0.1, 2)) ?></td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td><strong>$<?= esc(number_format($total * 1.1, 2)) ?></strong></td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
