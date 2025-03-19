<?php
$title = 'Invoice Preview';
$subTitle = 'Invoice Details';
$script = '<script>
    function printInvoice() {
        var printContents = document.getElementById("invoice").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>';
?>

<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-header">
        <div class="flex flex-wrap items-center justify-end gap-2">
            <a href="<?= base_url('send_invoice/' . $invoice['id']) ?>"
                class="btn btn-sm bg-primary-600 hover:bg-primary-700 text-white rounded-lg inline-flex items-center gap-1">
                <iconify-icon icon="pepicons-pencil:paper-plane" class="text-xl"></iconify-icon>
                Send Invoice
            </a>
            <a href="<?= base_url('download_invoice/' . $invoice['id']) ?>"
                class="btn btn-sm bg-warning-600 hover:bg-warning-700 text-white rounded-lg inline-flex items-center gap-1">
                <iconify-icon icon="solar:download-linear" class="text-xl"></iconify-icon>
                Download
            </a>

            <a href="<?= base_url('invoice_edit/' . $invoice['id']) ?>" class="btn btn-sm bg-success-600 hover:bg-success-700 text-white rounded-lg inline-flex items-center gap-1">
                <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                Edit
            </a>
            <button type="button" class="btn btn-sm bg-danger-600 hover:bg-danger-700 text-white rounded-lg inline-flex items-center gap-1" onclick="printInvoice()">
                <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                Print
            </button>

        </div>
    </div>

    <div class="card-body py-[60px]">
        <div class="grid grid-cols-1" id="invoice">
            <div class="max-w-[1174px] mx-auto w-full">
                <div class="shadow-4 border border-neutral-200 dark:border-neutral-600 rounded-lg">
                    <div class="p-5 flex flex-wrap justify-between gap-3 border-b border-neutral-200 dark:border-neutral-600">
                        <div>
                            <h3 class="text-xl">Invoice #<?= esc($invoice['id']) ?></h3>
                            <p class="mb-1 text-sm">Date Issued: <?= esc($invoice['created_at']) ?></p>
                            <p class="mb-0 text-sm">Due Date: <?= esc($invoice['due_date']) ?></p>
                        </div>
                        <div>
                            <img src="<?= base_url() . 'assets/images/logo.png' ?>" alt="Company Logo" class="mb-2">
                            <p class="mb-1 text-sm">Your Company Name</p>
                            <p class="mb-0 text-sm">your@email.com, +1234567890</p>
                        </div>
                    </div>

                    <div class="py-7 px-5">
                        <div class="flex flex-wrap justify-between align-items-end gap-3">
                            <!-- Client Info -->
                            <div>
                                <h6 class="text-base">Issued For:</h6>
                                <table class="text-sm text-secondary-light">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td class="ps-2">: <?= esc($invoice['client_name']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td class="ps-2">: <?= esc($invoice['client_address']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td class="ps-2">: <?= esc($invoice['client_phone']) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Invoice Details -->
                            <div>
                                <table class="text-sm text-secondary-light">
                                    <tbody>
                                        <tr>
                                            <td>Issue Date</td>
                                            <td class="ps-2">: <?= esc($invoice['created_at']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Order ID</td>
                                            <td class="ps-2">: #<?= esc($invoice['id']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Shipment ID</td>
                                            <td class="ps-2">: #<?= esc($invoice['shipment_id'] ?? 'N/A') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Invoice Items Table -->
                        <div class="mt-6">
                            <div class="table-responsive scroll-sm">
                                <table class="table bordered-table text-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-sm">SL.</th>
                                            <th scope="col" class="text-sm">Item</th>
                                            <th scope="col" class="text-sm">Qty</th>
                                            <th scope="col" class="text-sm">Unit</th>
                                            <th scope="col" class="text-sm">Unit Price</th>
                                            <th scope="col" class="text-end text-sm">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $total = 0; ?>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= esc($item['item_name']) ?></td>
                                                <td><?= esc($item['quantity']) ?></td>
                                                <td><?= esc($item['unit']) ?></td>
                                                <td>$<?= esc(number_format($item['unit_price'], 2)) ?></td>
                                                <td class="text-end">$<?= esc(number_format($item['total_price'], 2)) ?></td>
                                            </tr>
                                            <?php if (!empty($item['description'])): ?>
                                                <tr>
                                                    <td colspan="6" class="text-muted"><em><?= esc($item['description']) ?></em></td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php $total += $item['total_price']; ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </div>

                            <!-- Invoice Summary -->
                            <div class="flex flex-wrap justify-between gap-3">
                                <div>
                                    <p class="text-sm mb-0"><span class="text-neutral-600 dark:text-neutral-200 font-semibold">Sales By:</span> <?= esc($invoice['sales_by'] ?? 'N/A') ?></p>
                                    <p class="text-sm mb-0">Thanks for your business</p>
                                </div>
                                <div>
                                    <table class="text-sm">
                                        <tbody>
                                            <tr>
                                                <td class="pe-[64px]">Subtotal:</td>
                                                <td class="ps-6"><strong>$<?= esc(number_format($total, 2)) ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td class="pe-[64px]">Tax:</td>
                                                <td class="ps-6"><strong>$<?= esc(number_format($invoice['tax'] ?? 0, 2)) ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td class="pe-[64px]">Discount:</td>
                                                <td class="ps-6"><strong>$<?= esc(number_format($invoice['discount'] ?? 0, 2)) ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td class="pe-[64px] pt-4"><span class="text-neutral-600 dark:text-neutral-200 font-semibold">Total:</span></td>
                                                <td class="ps-6 pt-4"><strong>$<?= esc(number_format($total - ($invoice['discount'] ?? 0) + ($invoice['tax'] ?? 0), 2)) ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Signature Section -->
                        <div class="mt-16">
                            <div class="flex flex-wrap justify-between align-items-end">
                                <div class="text-sm border-t border-neutral-200 dark:border-neutral-600 inline-block px-3">Signature of Customer</div>
                                <div class="text-sm border-t border-neutral-200 dark:border-neutral-600 inline-block px-3">Signature of Authorized</div>
                            </div>
                        </div>

                        <p class="text-center text-secondary-light text-sm font-semibold mt-10">Thank you for your purchase!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>