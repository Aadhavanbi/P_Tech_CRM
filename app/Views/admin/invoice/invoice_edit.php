<?php
$title = 'Edit Invoice';
$subTitle = 'Invoice Edit';
$script = '<script src="' . base_url('assets/js/invoice.js') . '"></script>';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-header">
        <div class="flex flex-wrap items-center justify-end gap-2">
            <button type="submit" form="invoice-form" class="btn btn-sm btn-primary-600 rounded-lg inline-flex items-center gap-1">
                <iconify-icon icon="simple-line-icons:check" class="text-xl"></iconify-icon>
                Save
            </button>
        </div>
    </div>

    <div class="card-body py-[60px]">
        <form id="invoice-form" method="post" action="<?= base_url('invoice_update/' . $invoice['id']) ?>">
            <div class="grid grid-cols-1">
                <div class="max-w-[1174px] mx-auto w-full">
                    <div class="shadow-4 border border-neutral-200 dark:border-neutral-600 rounded-lg">
                        <div class="p-5 border-b border-neutral-200 dark:border-neutral-600">
                            <div class="flex flex-wrap justify-between gap-4">
                                <div>
                                    <h3 class="text-xl">Invoice #<?= str_pad($invoice['id'], 6, '0', STR_PAD_LEFT) ?></h3>
                                    <p class="mb-1 text-sm">Date Issued:
                                        <input type="date" id="invoice_date" value="<?= $invoice['invoice_date'] ?>" class="form-control" style="width: 65% !important;">
                                    </p>
                                    <p class="mb-0 text-sm">Date Due:
                                        <input type="date" id="due_date" value="<?= $invoice['due_date'] ?>" class="form-control" style="width: 65% !important;">
                                    </p>
                                </div>
                                <div>
                                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="mb-2">
                                    <p class="mb-1 text-sm">4517 Washington Ave. Manchester, Kentucky 39495</p>
                                    <p class="mb-0 text-sm">random@gmail.com, +1 543 2198</p>
                                </div>
                            </div>
                        </div>

                        <div class="py-7 px-5">
                            <div class="flex flex-wrap justify-between align-items-end gap-3">
                                <div>
                                    <h6 class="text-base">Issued For:</h6>
                                    <table class="text-sm text-secondary-light">
                                        <tbody>
                                            <!-- Client Selection -->
                                            <tr>
                                                <td>Name :</td>
                                                <td class="ps-2">
                                                    <select id="client_id" name="client_id" class="form-control">
                                                        <option value="">Select Client</option>
                                                        <?php foreach ($client_list as $client): ?>
                                                            <option value="<?= esc($client['id']) ?>"
                                                                data-address="<?= esc($client['address']) ?>"
                                                                data-phone="<?= esc($client['phone']) ?>"
                                                                <?= $invoice['client_id'] == $client['id'] ? 'selected' : '' ?>>
                                                                <?= esc($client['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <!-- Auto-filled Address -->
                                            <tr>
                                                <td>Address</td>
                                                <td class="ps-2">: <span id="client_address" class="editable underline"><?= esc($invoice['customer_address'] ?? '-') ?></span></td>
                                            </tr>

                                            <!-- Auto-filled Phone -->
                                            <tr>
                                                <td>Phone</td>
                                                <td class="ps-2">: <span id="client_phone" class="editable underline"><?= esc($invoice['customer_phone'] ?? '-') ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div>
                                    <table class="text-sm text-secondary-light">
                                        <tbody>
                                            <tr>
                                                <td>Issue Date</td>
                                                <td class="ps-2">: <span id="display_issue_date"><?= date('d M Y', strtotime($invoice['invoice_date'])) ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>Order ID</td>
                                                <td class="ps-2">: #<?= esc($invoice['order_id']) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Shipment ID</td>
                                                <td class="ps-2">: #<?= esc($invoice['shipment_id']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-6">
                                <div class="table-responsive scroll-sm">
                                    <table class="table bordered-table text-sm" id="invoice-table">
                                        <thead>
                                            <tr>
                                                <th>SL.</th>
                                                <th>Items</th>
                                                <th>Qty</th>
                                                <th>Units</th>
                                                <th>Unit Price</th>
                                                <th>Price</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="invoice-body" class="invoice-body">
                                            <?php foreach ($items as $key => $item) : ?>
                                                <tr class="invoice_body_<?= $key + 1 ?>">
                                                    <td><?= $key + 1 ?></td>
                                                    <td><input type="text" data-name="item_name" name="items[<?= $key ?>][name]" value="<?= esc($item['item_name']) ?>" class="form-control"></td>
                                                    <td><input type="number" data-name="item_qty" name="items[<?= $key ?>][quantity]" value="<?= $item['quantity'] ?>" class="form-control"></td>
                                                    <td><input type="text" data-name="item_units" name="items[<?= $key ?>][unit]" value="<?= esc($item['unit']) ?>" class="form-control"></td>
                                                    <td><input type="number" step="0.01" data-name="item_price" name="items[<?= $key ?>][unit_price]" value="<?= $item['unit_price'] ?>" class="form-control"></td>
                                                    <td><input type="number" step="0.01" data-name="item_total" name="items[<?= $key ?>][total_price]" value="<?= $item['total_price'] ?>" class="form-control"></td>
                                                    <td class="text-center">
                                                        <button type="button" class="remove-row btn btn-danger btn-sm">
                                                            <iconify-icon icon="ic:twotone-close" class="text-xl"></iconify-icon>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="description-row invoice_body_<?= $key + 1 ?>"> <!-- Corrected dynamic class -->
                                                    <td colspan="7">
                                                        <textarea name="items[<?= $key ?>][description]" class="form-control" data-name="item_description" placeholder="Enter description..."><?= esc($item['description'] ?? '') ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>

                                <button type="button" id="addRow" class="btn btn-sm btn-primary-600 rounded-lg mt-6">
                                    <iconify-icon icon="simple-line-icons:plus"></iconify-icon> Add New
                                </button>

                                <div class="flex flex-wrap justify-between gap-3 mt-6">
                                    <div>
                                        <p class="text-sm mb-0">Thanks for your business</p>
                                    </div>
                                    <div>
                                        <table class="text-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="pe-[64px]">Subtotal:</td>
                                                    <td class="ps-6">
                                                        <span id="subtotal_amount" class="text-neutral-600 dark:text-neutral-200 font-semibold">
                                                            $<?= number_format($invoice['subtotal'], 2) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-[64px]">Discount:</td>
                                                    <td class="ps-6">
                                                        <input type="number" id="discount_input" class="form-control text-neutral-600 dark:text-neutral-200 font-semibold"
                                                            value="<?= number_format($invoice['discount'], 2) ?>" step="0.01">
                                                        <span id="discount_amount" style="display: none;">
                                                            $<?= number_format($invoice['discount'], 2) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-[64px] border-b border-neutral-200 dark:border-neutral-600 pb-4">Tax:</td>
                                                    <td class="ps-6 border-b border-neutral-200 dark:border-neutral-600 pb-4">
                                                        <span id="tax_amount" class="text-neutral-600 dark:text-neutral-200 font-semibold">
                                                            $<?= number_format($invoice['tax'], 2) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-[64px] border-b border-neutral-200 dark:border-neutral-600 pb-4">Total:</td>
                                                    <td class="ps-6 border-b border-neutral-200 dark:border-neutral-600 pb-4">
                                                        <span id="total_amount" class="text-neutral-600 dark:text-neutral-200 font-semibold">
                                                            $<?= number_format($invoice['total_amount'], 2) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="mt-16 text-center text-sm font-semibold">Thank you for your purchase!</div>

                            <div class="flex justify-between mt-16">
                                <div class="text-sm border-t inline-block px-3">Signature of Customer</div>
                                <div class="text-sm border-t inline-block px-3">Signature of Authorized</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>