<?php
$title = 'Invoice List';
$subTitle = 'Invoice List';
$script = '<script src="' . base_url('public/assets/js/invoice.js') . '"></script>';
?>

<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="grid grid-cols-12">
    <div class="col-span-12">
        <div class="card border-0">
            <div class="card-header flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span>Show</span>
                        <select class="form-select form-select-sm w-auto dark:bg-dark-2 dark:text-white">
                            <option>10</option>
                            <option>15</option>
                            <option>20</option>
                        </select>
                    </div>
                    <div class="icon-field relative">
                        <input type="text" name="#0" class="bg-white dark:bg-dark-2 ps-10 border-neutral-200 dark:border-neutral-500 rounded-lg w-auto" placeholder="Search">
                        <span class="icon absolute top-1/2 left-0 text-lg flex">
                            <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <select id="filterStatus" class="form-select form-select-sm w-auto dark:bg-dark-2 dark:text-white border-neutral-200 dark:border-neutral-500">
                        <option value="">All</option>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending</option>
                        <option value="Overdue">Overdue</option>
                    </select>

                    <a href="invoice_add" class="btn btn-sm text-white bg-primary-600 hover:bg-primary-700 flex items-center gap-2"><i class="ri-add-line"></i> Create Invoice</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="form-check style-check flex items-center gap-2">
                                        <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                        <label class="form-check-label" for="checkAll">
                                            S.L
                                        </label>
                                    </div>
                                </th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Name</th>
                                <th scope="col">Issued Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($invoices)) : ?>
                                <?php foreach ($invoices as $invoice) : ?>
                                    <tr>
                                        <td>
                                            <div class="form-check style-check flex items-center gap-2">
                                                <input class="form-check-input" type="checkbox" value="<?= $invoice['id'] ?>" id="check<?= $invoice['id'] ?>">
                                                <label class="form-check-label" for="check<?= $invoice['id'] ?>">
                                                    <?= $invoice['id'] ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('invoice_edit/' . $invoice['id']) ?>" class="text-primary-600">#<?= str_pad($invoice['id'], 6, '0', STR_PAD_LEFT) ?></a>
                                        </td>
                                        <td>
                                            <div class="flex items-center">
                                                <img src="<?= base_url('assets/images/user-list/default-user.png') ?>" alt="Customer Image" class="shrink-0 me-3 rounded-lg w-8 h-8">
                                                <h6 class="text-base mb-0 font-medium grow"><?= esc($invoice['client_name']) ?></h6>
                                            </div>
                                        </td>
                                        <td><?= date('d M Y', strtotime($invoice['invoice_date'])) ?></td>
                                        <td>$<?= number_format($invoice['total_amount'], 2) ?></td>
                                        <td>
                                            <span class="<?= ($invoice['status'] == 'Paid') ? 'bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400' : (($invoice['status'] == 'Overdue') ? 'bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400' : 'bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400') ?> px-6 py-1.5 rounded-full font-medium text-sm">
                                                <?= esc($invoice['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <a href="<?= base_url('invoice_preview/' . $invoice['id']) ?>" class="w-8 h-8 bg-primary-50 dark:bg-primary-600/25 text-primary-600 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                                </a>
                                                <a href="<?= base_url('invoice_edit/' . $invoice['id']) ?>" class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </a>
                                                <a href="javascript:void(0)" onclick="deleteInvoice(<?= $invoice['id'] ?>)" class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center">No invoices found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 mt-6">
                    <span id="showingText">Showing 1 to 10 of 12 entries</span>
                    <ul class="pagination flex flex-wrap items-center gap-2 justify-center">
                        <li class="page-item">
                            <a class="page-link text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8 bg-white dark:bg-neutral-700"
                                href="javascript:void(0)"><iconify-icon icon="ep:d-arrow-left" class="text-xl"></iconify-icon></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link bg-primary-600 text-white font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8"
                                href="javascript:void(0)">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link bg-primary-50 dark:bg-primary-600/25 text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8"
                                href="javascript:void(0)">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link bg-primary-50 dark:bg-primary-600/25 text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8"
                                href="javascript:void(0)">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8 bg-white dark:bg-neutral-700"
                                href="javascript:void(0)"> <iconify-icon icon="ep:d-arrow-right" class="text-xl"></iconify-icon> </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>