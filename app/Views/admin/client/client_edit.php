<?php
$title = 'Edit Client';
$subTitle = 'Client Information';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-body">
        <h6 class="mb-1.5 text-xl">Edit Client</h6>
        <p class="text-neutral-400">Update the client details below.</p>

        <form action="<?= base_url('client_update/' . $client['id']) ?>" method="post">
            <?= csrf_field(); ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="inline-block mb-2">Client Name*</label>
                    <input type="text" class="form-control" name="name" value="<?= esc($client['name']) ?>" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Email*</label>
                    <input type="email" class="form-control" name="email" value="<?= esc($client['email']) ?>" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Phone*</label>
                    <input type="text" class="form-control" name="phone" value="<?= esc($client['phone']) ?>" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Company</label>
                    <input type="text" class="form-control" name="company" value="<?= esc($client['company']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">Address</label>
                    <input type="text" class="form-control" name="address" value="<?= esc($client['address']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">City</label>
                    <input type="text" class="form-control" name="city" value="<?= esc($client['city']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">State</label>
                    <input type="text" class="form-control" name="state" value="<?= esc($client['state']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">Zip Code</label>
                    <input type="text" class="form-control" name="zip_code" value="<?= esc($client['zip_code']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">Country</label>
                    <input type="text" class="form-control" name="country" value="<?= esc($client['country']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">Project Live Date</label>
                    <input type="date" class="form-control" name="project_live_date" value="<?= esc($client['project_live_date']) ?>">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="<?= base_url('clients') ?>" class="btn btn-danger-600 px-6">Cancel</a>
                <button type="submit" class="btn btn-primary-600 px-6">Update Client</button>
            </div>
        </form>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>
