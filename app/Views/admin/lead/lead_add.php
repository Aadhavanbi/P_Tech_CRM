<?php
$title = 'Add Lead';
$subTitle = 'Lead Information';
$script = '<script src="assets/js/lead.js"></script>';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>

<div class="card border-0">
    <div class="card-body">
        <h6 class="mb-1.5 text-xl">Add New Lead</h6>
        <p class="text-neutral-400">Fill in the lead details below.</p>

        <form id="lead-form" method="post" action="<?= base_url('lead_save') ?>">
            <?= csrf_field(); ?> <!-- CSRF Token for Security -->

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="inline-block mb-2">Full Name*</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                </div>
                <div>
                    <label class="inline-block mb-2">Company*</label>
                    <input type="text" name="company" class="form-control" placeholder="Enter Company Name">
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
                    <label class="inline-block mb-2">Status*</label>
                    <select name="status" class="form-control" required>
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Converted">Converted</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
                <div>
                    <label class="inline-block mb-2">Stage*</label>
                    <select name="stage" class="form-control" required>
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Qualified">Qualified</option>
                        <option value="Proposal Sent">Proposal Sent</option>
                        <option value="Won">Won</option>
                        <option value="Lost">Lost</option>
                    </select>
                </div>
                <div>
                    <label class="inline-block mb-2">Lead Source*</label>
                    <input type="text" name="lead_source" class="form-control" placeholder="Enter Lead Source">
                </div>
                <div>
                    <label class="inline-block mb-2">Assigned To*</label>
                    <input type="text" name="assigned_to" class="form-control" placeholder="Enter Assignee">
                </div>
                <div>
                    <label class="inline-block mb-2">Assignee</label>
                    <input type="text" name="assignee" class="form-control" placeholder="Enter Assignee">
                </div>
                <div>
                    <label class="inline-block mb-2">Assigner</label>
                    <input type="text" name="assigner" class="form-control" placeholder="Enter Assigner">
                </div>
                <div>
                    <label class="inline-block mb-2">Call Status</label>
                    <select name="call_status" class="form-control">
                        <option value="Not Contacted">Not Contacted</option>
                        <option value="Attempted">Attempted</option>
                        <option value="Connected">Connected</option>
                        <option value="Follow-up Required">Follow-up Required</option>
                    </select>
                </div>
            </div>


            <div class="mt-6 text-end">
                <button type="submit" class="btn btn-primary-600 px-6">Save Lead</button>
            </div>
        </form>
    </div>
</div>

<?= view('partials/layouts/layoutBottom.php'); ?>