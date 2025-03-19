<?php
$title = 'Employee List';
$subTitle = 'Employee List';
$script = '<script src="assets/js/employee.js"></script>';
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
                        <input type="text" name="search" class="bg-white dark:bg-dark-2 ps-10 border-neutral-200 dark:border-neutral-500 rounded-lg w-auto" placeholder="Search">
                        <span class="icon absolute top-1/2 left-0 text-lg flex">
                            <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <select class="form-select form-select-sm w-auto dark:bg-dark-2 dark:text-white border-neutral-200 dark:border-neutral-500">
                        <option>Department</option>
                        <option>HR</option>
                        <option>IT</option>
                        <option>Sales</option>
                    </select>
                    <a href="employee_add" class="btn btn-sm text-white bg-primary-600 hover:bg-primary-700 flex items-center gap-2">
                        <i class="ri-add-line"></i> Add Employee
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">S.L</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Position</th>
                                <th scope="col">Salary</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($employees)) : ?>
                                <?php foreach ($employees as $index => $employee) : ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= esc($employee['name']); ?></td>
                                        <td><?= esc($employee['email']); ?></td>
                                        <td><?= esc($employee['phone']); ?></td>
                                        <td><?= esc($employee['position'] ?? 'N/A'); ?></td>
                                        <td>$<?= number_format($employee['salary'], 2); ?></td>
                                        <td>
                                            <span class="px-6 py-1.5 rounded-full font-medium text-sm 
                                            <?= ($employee['status'] == 'Active') ? 'bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400' : 'bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400'; ?>">
                                                <?= $employee['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="items-center gap-2">
                                                <!-- <a href="<?= base_url('employee_view/' . $employee['id']); ?>" class="w-8 h-8 bg-primary-50 dark:bg-primary-600/25 text-primary-600 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                                </a> -->
                                                <a href="<?= base_url('employee_edit/' . $employee['id']); ?>" class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </a>
                                                <a href="<?= base_url('employee_delete/' . $employee['id']); ?>" onclick="return confirm('Are you sure you want to delete this employee?');" class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center">No employees found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 mt-6">
                    <!-- <span>Showing 1 to 10 of 20 entries</span> -->
                    <span>Showing <?= count($employees); ?> entries</span>
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