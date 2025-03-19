<?php
$title = 'Edit Lead';
$subTitle = 'Update Lead Information';
$script = '<script src="assets/js/lead.js"></script>';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-body">
        <h6 class="mb-1.5 text-xl">Edit Lead</h6>
        <p class="text-neutral-400">Update the lead details below.</p>

        <form id="lead-form" method="post" action="<?= base_url('lead_update/' . $lead['id']) ?>">
            <?= csrf_field(); ?> <!-- CSRF Token for Security -->

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="inline-block mb-2">Full Name*</label>
                    <input type="text" name="name" class="form-control" value="<?= esc($lead['name']) ?>" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Company*</label>
                    <input type="text" name="company" class="form-control" value="<?= esc($lead['company']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">Email*</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($lead['email']) ?>" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Phone*</label>
                    <input type="text" name="phone" class="form-control" value="<?= esc($lead['phone']) ?>" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Status*</label>
                    <select name="status" class="form-control" required>
                        <option value="Open" <?= $lead['status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                        <option value="Closed" <?= $lead['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>
                <div>
                    <label class="inline-block mb-2">Stage*</label>
                    <select name="stage" class="form-control" required>
                        <option value="New" <?= $lead['stage'] == 'New' ? 'selected' : '' ?>>New</option>
                        <option value="Contacted" <?= $lead['stage'] == 'Contacted' ? 'selected' : '' ?>>Contacted</option>
                        <option value="Qualified" <?= $lead['stage'] == 'Qualified' ? 'selected' : '' ?>>Qualified</option>
                        <option value="Proposal Sent" <?= $lead['stage'] == 'Proposal Sent' ? 'selected' : '' ?>>Proposal Sent</option>
                        <option value="Won" <?= $lead['stage'] == 'Won' ? 'selected' : '' ?>>Won</option>
                        <option value="Lost" <?= $lead['stage'] == 'Lost' ? 'selected' : '' ?>>Lost</option>
                    </select>
                </div>
                <div>
                    <label class="inline-block mb-2">Lead Source*</label>
                    <input type="text" name="lead_source" class="form-control" value="<?= esc($lead['lead_source']) ?>">
                </div>
                <div>
                    <label class="inline-block mb-2">Assigned To*</label>
                    <input type="text" name="assigned_to" class="form-control" value="<?= esc($lead['assigned_to']) ?>">
                </div>
            </div>

            <div class="mt-6 text-end">
                <button type="submit" class="btn btn-primary-600 px-6">Update Lead</button>
            </div>
        </form>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>
