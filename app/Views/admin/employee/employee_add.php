<?php
$title = 'Add Employee';
$subTitle = 'Employee Information';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-body">
        <h6 class="mb-1.5 text-xl">Add New Employee</h6>
        <p class="text-neutral-400">Fill in the employee details below.</p>

        <form id="employee-form" method="post" action="<?= base_url('employee_save') ?>">
            <?= csrf_field(); ?> <!-- CSRF Token for Security -->

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="inline-block mb-2">Full Name*</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Email*</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Phone*</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Position</label>
                    <input type="text" name="position" class="form-control" placeholder="Enter Position">
                </div>
                <div>
                    <label class="inline-block mb-2">Salary</label>
                    <input type="number" name="salary" class="form-control" placeholder="Enter Salary">
                </div>
                <div>
                    <label class="inline-block mb-2">Status</label>
                    <select name="status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 text-end">
                <button type="submit" class="btn btn-primary-600 px-6">Save Employee</button>
            </div>
        </form>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>
