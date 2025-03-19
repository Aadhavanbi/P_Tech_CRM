<?php
$title = 'Invoice List';
$subTitle = 'Invoice List';
$script = '<script src="' . base_url('assets/js/invoice.js') . '"></script>';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-header">
        <div class="flex flex-wrap items-center justify-end gap-2">
            <!-- <a href="javascript:history.back();" class="btn btn-sm text-white bg-secondary-600 hover:bg-secondary-700 flex items-center gap-2">
                <iconify-icon icon="ic:round-arrow-back"></iconify-icon> Back
            </a> -->
            <button type="button" id="saveInvoice" class="btn btn-sm btn-primary-600 rounded-lg inline-flex items-center gap-1">
                <iconify-icon icon="simple-line-icons:check" class="text-xl"></iconify-icon>
                Save
            </button>
        </div>
    </div>
    <div class="card-body py-[60px]">
        <div class="grid grid-cols-1" id="invoice">
            <div class="max-w-[1174px] mx-auto w-full">
                <div class="shadow-4 border border-neutral-200 dark:border-neutral-600 rounded-lg">
                    <div class="p-5 border-b border-neutral-200 dark:border-neutral-600">
                        <div class="flex flex-wrap justify-between gap-4">
                            <div class="">
                                <h3 class="text-xl">Invoice #3492</h3>

                                <p class="mb-1 text-sm">
                                    Date Issued:
                                    <input type="date" id="invoice_date" class="editable date-input form-control" style="width: 65% !important;">
                                    <!-- <span class="text-success-600"><iconify-icon icon="mage:edit"></iconify-icon></span> -->
                                </p>

                                <p class="mb-0 text-sm">
                                    Date Due:
                                    <input type="date" id="due_date" class="editable date-input form-control" style="width: 65% !important;">
                                    <!-- <span class="text-success-600"><iconify-icon icon="mage:edit"></iconify-icon></span> -->
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
                                            <td>Name :</td>
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
                                            <td>Address</td>
                                            <td class="ps-2">: <span id="client_address" class="editable underline">-</span></td>
                                        </tr>
                                        <tr>
                                            <td>Phone number</td>
                                            <td class="ps-2">: <span id="client_phone" class="editable underline">-</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div>
                                <table class="text-sm text-secondary-light">
                                    <tbody>
                                        <tr>
                                            <td>Issus Date</td>
                                            <td class="ps-2">: <span id="display_issue_date">25 Jan 2025</span></td>
                                        </tr>
                                        <tr>
                                            <td>Order ID</td>
                                            <td class="ps-2">:#653214</td>
                                        </tr>
                                        <tr>
                                            <td>Shipment ID</td>
                                            <td class="ps-2">:#965215</td>
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
                                            <th scope="col" class="text-sm">SL.</th>
                                            <th scope="col" class="text-sm">Items</th>
                                            <th scope="col" class="text-sm">Qty</th>
                                            <th scope="col" class="text-sm">Units</th>
                                            <th scope="col" class="text-sm">Unit Price</th>
                                            <th scope="col" class="text-sm">Total Price</th>
                                            <th scope="col" class="text-center text-sm">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice-body" class="invoice-body">
                                        <tr class="invoice_body_1">
                                            <td>01</td>
                                            <td><input type="text" class="form-control" data-name="item_name" value="Apple's Shoes"></td>
                                            <td><input type="number" class="form-control" data-name="item_qty" value="5"></td>
                                            <td><input type="text" class="form-control" data-name="item_units" value="PC"></td>
                                            <td><input type="number" class="form-control" data-name="item_price" value="200" step="0.01"></td>
                                            <td><input type="number" class="form-control" data-name="item_total" value="1000.00" step="0.01"></td>
                                            <td class="text-center">
                                                <button type="button" class="remove-row">
                                                    <iconify-icon icon="ic:twotone-close" class="text-danger-600 text-xl"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="description-row invoice_body_1">
                                            <td colspan="7">
                                                <textarea class="form-control" data-name="item_description" placeholder="Enter description..."></textarea>
                                            </td>
                                        </tr>
                                    </tbody>


                                </table>
                            </div>

                            <div>
                                <button type="button" id="addRow" class="btn btn-sm btn-primary-600 rounded-lg inline-flex items-center gap-1 mt-6">
                                    <iconify-icon icon="simple-line-icons:plus" class="text-xl"></iconify-icon>
                                    Add New
                                </button>
                            </div>

                            <div class="flex flex-wrap justify-between gap-3 mt-6">
                                <div>
                                    <p class="text-sm mb-0"><span class="text-neutral-600 dark:text-neutral-200 font-semibold">Sales By:</span> Jammal</p>
                                    <p class="text-sm mb-0">Thanks for your business</p>
                                </div>
                                <div>
                                    <table class="text-sm">
                                        <tbody>
                                            <tr>
                                                <td class="pe-[64px]">Subtotal:</td>
                                                <td class="ps-6">
                                                    <span id="subtotal_amount" class="text-neutral-600 dark:text-neutral-200 font-semibold">$4000.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pe-[64px]">Discount:</td>
                                                <td class="ps-6">
                                                    <input type="number" id="discount_input" class="form-control text-neutral-600 dark:text-neutral-200 font-semibold" value="0.00" step="0.01">
                                                    <span id="discount_amount" style="display: none;">$0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pe-[64px] border-b border-neutral-200 dark:border-neutral-600 pb-4">Tax:</td>
                                                <td class="ps-6 border-b border-neutral-200 dark:border-neutral-600 pb-4">
                                                    <span class="text-neutral-600 dark:text-neutral-200 font-semibold">0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pe-[64px] border-b border-neutral-200 dark:border-neutral-600 pb-4">Total:</td>
                                                <td class="ps-6 border-b border-neutral-200 dark:border-neutral-600 pb-4">
                                                    <span id="total_amount" class="text-neutral-600 dark:text-neutral-200 font-semibold"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-16">
                            <p class="text-center text-secondary-light text-sm font-semibold">Thank you for your purchase!</p>
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