<?php
$title = 'Quotation List';
$subTitle = 'Quotation List';
$script = '<script src="' . base_url('assets/js/invoice.js') . '"></script>';
?>

<?= view('partials/layouts/layoutTop.php', ['title' => 'Quotation List', 'subTitle' => 'Quotation List']); ?>

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
                        <input type="text" class="bg-white dark:bg-dark-2 ps-10 border-neutral-200 dark:border-neutral-500 rounded-lg w-auto" placeholder="Search">
                        <span class="icon absolute top-1/2 left-0 text-lg flex">
                            <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="<?= base_url('quote_add') ?>" class="btn btn-sm text-white bg-primary-600 hover:bg-primary-700 flex items-center gap-2">
                        <i class="ri-add-line"></i> Create Quotation
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">S.L</th>
                                <th scope="col">Quote No</th>
                                <th scope="col">Client</th>
                                <th scope="col">Quote Date</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($quotes)) : ?>
                                <?php $count = 1;
                                foreach ($quotes as $quote) : ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><a href="javascript:void(0)" class="text-primary-600">#<?= $quote['quote_no'] ?></a></td>
                                        <td><?= esc($quote['client_name']) ?></td>
                                        <td><?= date('d M Y', strtotime($quote['quote_date'])) ?></td>
                                        <td><?= date('d M Y', strtotime($quote['expiry_date'])) ?></td>
                                        <td>$<?= number_format($quote['total_amount'], 2) ?></td>
                                        <td>
                                            <?php
                                            $statusClasses = [
                                                'Draft' => 'bg-gray-100 dark:bg-gray-600/25 text-gray-600 dark:text-gray-400',
                                                'Sent' => 'bg-blue-100 dark:bg-blue-600/25 text-blue-600 dark:text-blue-400',
                                                'Accepted' => 'bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400',
                                                'Rejected' => 'bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400'
                                            ];
                                            ?>
                                            <span class="<?= $statusClasses[$quote['status']] ?> px-6 py-1.5 rounded-full font-medium text-sm"><?= $quote['status'] ?></span>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <a href="<?= base_url('quote/view/' . $quote['id']) ?>" class="w-8 h-8 bg-primary-50 dark:bg-primary-600/25 text-primary-600 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                                </a>
                                                <a href="<?= base_url('quote/edit/' . $quote['id']) ?>" class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </a>
                                                <a href="<?= base_url('quote/delete/' . $quote['id']) ?>" class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center">No quotations found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 mt-6">
                    <span>Showing <?= count($quotes) ?> of <?= count($quotes) ?> entries</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>