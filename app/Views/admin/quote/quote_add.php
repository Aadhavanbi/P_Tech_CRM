<?php
$title = 'Add Quote';
$subTitle = 'Create New Quote';
$script = '<script src="' . base_url('assets/js/quote.js') . '"></script>';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-header">
        <div class="flex flex-wrap items-center justify-end gap-2">
            <button type="button" id="saveQuote" class="btn btn-sm btn-primary-600 rounded-lg inline-flex items-center gap-1">
                <iconify-icon icon="simple-line-icons:check" class="text-xl"></iconify-icon>
                Save Quote
            </button>
        </div>
    </div>
    <div class="card-body py-[60px]">
        <div class="grid grid-cols-1" id="quote">
            <div class="max-w-[1174px] mx-auto w-full">
                <div class="shadow-4 border border-neutral-200 dark:border-neutral-600 rounded-lg">
                    <div class="p-5 border-b border-neutral-200 dark:border-neutral-600">
                        <div class="flex flex-wrap justify-between gap-4">
                            <div>
                                <h3 class="text-xl">Quote #<span id="quote_no">Q-<?= time(); ?></span></h3>
                                <p class="mb-1 text-sm">
                                    Quote Date:
                                    <input type="date" id="quote_date" class="form-control">
                                </p>
                                <p class="mb-0 text-sm">
                                    Expiry Date:
                                    <input type="date" id="expiry_date" class="form-control">
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
                                        <tr>
                                            <td>Name:</td>
                                            <td class="ps-2">
                                                <select id="client_id" class="form-control" onchange="fetchClientDetails(this.value)">
                                                    <option value="">Select Client</option>
                                                    <?php foreach ($clients as $client): ?>
                                                        <option value="<?= $client['id']; ?>" data-address="<?= $client['address']; ?>" data-phone="<?= $client['phone']; ?>">
                                                            <?= $client['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td class="ps-2"><span id="client_address">-</span></td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td class="ps-2"><span id="client_phone">-</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="table-responsive scroll-sm">
                                <table class="table bordered-table text-sm" id="quote-table">
                                    <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Items</th>
                                            <th>Qty</th>
                                            <th>Units</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="quote-body">
                                        <tr class="quote_body_1">
                                            <td>01</td>
                                            <td><input type="text" class="form-control item_name" name="item_name[]" value="Item Name"></td>
                                            <td><input type="number" class="form-control item_qty" name="item_qty[]" value="1" oninput="calculateTotal()"></td>
                                            <td><input type="text" class="form-control item_units" name="item_units[]" value=""></td>
                                            <td><input type="number" class="form-control item_price" name="item_price[]" step="0.01" value="0.00" oninput="calculateTotal()"></td>
                                            <td><input type="number" class="form-control item_total" name="item_total[]" step="0.01" value="0.00" readonly></td>
                                            <td class="text-center">
                                                <button type="button" class="remove-row" onclick="removeRow(this)">
                                                    <iconify-icon icon="ic:twotone-close" class="text-danger-600 text-xl"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="description-row quote_body_1">
                                            <td colspan="7">
                                                <textarea class="form-control" data-name="item_description" placeholder="Enter description..."></textarea>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                            <button type="button" id="addRow" class="btn btn-sm btn-primary-600 rounded-lg mt-6">
                                <iconify-icon icon="simple-line-icons:plus" class="text-xl"></iconify-icon>
                                Add New Item
                            </button>

                            <div class="mt-6">
                                <table class="text-sm">
                                    <tbody>
                                        <tr>
                                            <td>Subtotal:</td>
                                            <td class="ps-6"><span id="subtotal_amount">$0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Discount:</td>
                                            <td class="ps-6">
                                                <input type="number" id="discount_input" class="form-control" value="0.00" step="0.01">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tax:</td>
                                            <td class="ps-6"><span>0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Total:</td>
                                            <td class="ps-6"><span id="total_amount">$0.00</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Terms and Conditions Section -->
                            <div class="mt-6">
                                <h6 class="text-base">Terms and Conditions</h6>
                                <textarea id="terms_conditions" class="form-control" placeholder="Enter terms and conditions here..."></textarea>
                            </div>
                        </div>

                        <div class="mt-16 text-center">
                            <p class="text-secondary-light text-sm font-semibold">Thank you for your business!</p>
                        </div>

                        <div class="flex flex-wrap justify-between align-items-end mt-16">
                            <div class="text-sm border-t border-neutral-200 dark:border-neutral-600 inline-block px-3">Signature of Customer</div>
                            <div class="text-sm border-t border-neutral-200 dark:border-neutral-600 inline-block px-3">Signature of Authorized</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>