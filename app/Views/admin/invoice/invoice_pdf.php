<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= esc($invoice['id']) ?></title>
</head>

<!-- <body style="font-family: Arial, sans-serif;font-size: 12px;margin: 0;"> -->

<body style="">

    <!-- <div style="width: 100%; border: 1px solid #ddd; "> -->
    <div style="width: 100%; ">
        <table style="width: 100%;">
            <tr>
                <td style="width: 100%; text-align: center; padding-left: 40%;">
                    <h1>Pugazhvi Tech</h1>
                    <p>NS7, New no.37, 15th Avenue, Ashok Nagar, Chennai - 600083</p>
                </td>
                <td style="width: 40%; text-align: right;">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Company Logo" style="max-width: 100px;">
                </td>
            </tr>
        </table>



        <table style="width: 100%;">
            <tr>

                <!-- <td style="text-align: right;">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" style="max-width: 100px;">
                    <p>Pugazhvi Tech</p>
                    <p>NS7, New no.37, <br>
                        15th Avenue, <br>
                        Ashok Nagar,<br>
                        Chennai - 600083</p>
                    <p>info@pugazhvi.com, +91 900-348-0838</p>
                </td> -->
            </tr>
        </table>

        <hr>

        <table style="width: 90%;">
            <tr>
                <td>
                    <h4>Invoiced To:</h4>
                    <p>Name: <?= esc($invoice['client_name']) ?></p>
                    <p>Address: <?= esc($invoice['client_address']) ?></p>
                    <p>Phone: <?= esc($invoice['client_phone']) ?></p>
                </td>
                <td style="text-align: right;">
                    <h2>Invoice #<?= esc($invoice['id']) ?></h2>
                    <p>Status: <?= esc($invoice['status']) ?></p>
                    <p>Date Issued: <?= esc($invoice['invoice_date']) ?></p>
                    <p>Due Date: <?= esc($invoice['due_date']) ?></p>
                    <p>Amount Due: <?= $invoice['total_amount'] - $invoice['paid_amount'] ?></p>
                </td>
                <!-- <td style="text-align: right;">
                    <h4>Invoice Details:</h4>
                    <p>Order ID: #<?= esc($invoice['id']) ?></p>
                    <p>Shipment ID: <?= esc($invoice['shipment_id'] ?? 'N/A') ?></p>
                </td> -->
            </tr>
        </table>

        <table id="invoice_body" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="/* background: #007BFF; */color: white;border-bottom: 1px solid #ddd;background-image: linear-gradient(180deg, #223794 0%, #3c84e0 100%);">
                    <th style="padding: 5px;border: 1px solid #ddd;color: white;">SL</th>
                    <th style="padding: 5px; border: 1px solid #ddd;color: white;">Item</th>
                    <th style="padding: 5px; border: 1px solid #ddd;color: white;">Qty</th>
                    <th style="padding: 5px; border: 1px solid #ddd;color: white;">Unit</th>
                    <th style="padding: 5px; border: 1px solid #ddd;color: white;">Unit Price</th>
                    <th style="padding: 5px; border: 1px solid #ddd; text-align: right;color: white;">Total</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1;
                $total = 0; ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td style="padding: 5px; border: 1px solid #ddd;"><?= $i++ ?></td>
                        <td style="padding: 5px; border: 1px solid #ddd;"><?= esc($item['item_name']) ?></td>
                        <td style="padding: 5px; border: 1px solid #ddd;"><?= esc($item['quantity']) ?></td>
                        <td style="padding: 5px; border: 1px solid #ddd;"><?= esc($item['unit']) ?></td>
                        <td style="padding: 5px; border: 1px solid #ddd;">$<?= esc(number_format($item['unit_price'], 2)) ?></td>
                        <td style="padding: 5px; border: 1px solid #ddd; text-align: right;">$<?= esc(number_format($item['total_price'], 2)) ?></td>
                    </tr>

                    <!-- ✅ Add Description Row Below Item If Available -->
                    <?php if (!empty($item['description'])): ?>
                        <tr>
                            <td colspan="6" style="padding: 5px; border: 1px solid #ddd; font-style: italic; color: #666;">
                                <?= esc($item['description']) ?>
                            </td>
                        </tr>
                    <?php endif; ?>

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