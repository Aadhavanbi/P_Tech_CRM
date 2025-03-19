<?php
$title = 'Add Client';
$subTitle = 'Client Information';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-body">
        <h6 class="mb-1.5 text-xl">Add New Client</h6>
        <p class="text-neutral-400">Fill in the client details below.</p>

        <form action="<?= base_url('client_save') ?>" method="post">
            <?= csrf_field(); ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="inline-block mb-2">Client Name*</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Client Name" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Email*</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Phone*</label>
                    <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Company</label>
                    <input type="text" class="form-control" name="company" placeholder="Enter Company Name">
                </div>
                <div>
                    <label class="inline-block mb-2">Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter Address">
                </div>
                <div>
                    <label class="inline-block mb-2">City</label>
                    <input type="text" class="form-control" name="city" placeholder="Enter City">
                </div>
                <div>
                    <label class="inline-block mb-2">State</label>
                    <input type="text" class="form-control" name="state" placeholder="Enter State">
                </div>
                <div>
                    <label class="inline-block mb-2">Zip Code</label>
                    <input type="text" class="form-control" name="zip_code" placeholder="Enter Zip Code">
                </div>
                <div>
                    <label class="inline-block mb-2">Country</label>
                    <input type="text" class="form-control" name="country" placeholder="Enter Country">
                </div>
                <div>
                    <label class="inline-block mb-2">Project Live Date</label>
                    <input type="date" class="form-control" name="project_live_date">
                </div>
            </div>

            <div class="mt-6 text-end">
                <a href="<?= base_url('clients') ?>" class="btn btn-danger-600 px-6">Cancel</a>
                <button type="submit" class="btn btn-primary-600 px-6">Save Client</button>
            </div>
        </form>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>