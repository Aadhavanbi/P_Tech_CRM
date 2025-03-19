<?php
$title = 'Lead List';
$subTitle = 'Lead List';
$script = '<script src="assets/js/lead.js"></script>';
?>
<?= view('partials/layouts/layoutTop.php', ['title' => $title, 'subTitle' => $subTitle]); ?>
<style>
    /* Blur effect for everything except modal */
    .blur-bg>*:not(#statusModal) {
        filter: blur(5px);
        transition: filter 0.3s ease-in-out;
    }
</style>
<div class="grid grid-cols-12 test_for_blur">
    <div class="col-span-12">
        <div class="card border-0">
            <div class="card-header flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Show Entries Dropdown -->
                    <div class="flex items-center gap-2">
                        <span>Show</span>
                        <select id="showEntriesSelect" class="form-select form-select-sm w-auto dark:bg-dark-2 dark:text-white">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                    <!-- Search Field -->
                    <div class="icon-field relative">
                        <input type="text" id="searchInput" class="bg-white dark:bg-dark-2 ps-10 border-neutral-200 dark:border-neutral-500 rounded-lg w-auto" placeholder="Search">
                        <span class="icon absolute top-1/2 left-0 text-lg flex">
                            <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Stage Filter -->
                    <select id="filterStage" class="form-select form-select-sm w-auto dark:bg-dark-2 dark:text-white border-neutral-200 dark:border-neutral-500">
                        <option value="">All Stages</option>
                        <option value="Prospect">Prospect</option>
                        <option value="Negotiation">Negotiation</option>
                        <option value="Proposal Sent">Proposal Sent</option>
                        <option value="Won">Won</option>
                        <option value="Lost">Lost</option>
                    </select>

                    <!-- Status Filter -->
                    <select id="filterStatus" class="form-select form-select-sm w-auto dark:bg-dark-2 dark:text-white border-neutral-200 dark:border-neutral-500">
                        <option value="">All Status</option>
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Converted">Converted</option>
                        <option value="Closed">Closed</option>
                    </select>
                    <a href="lead_add" class="btn btn-sm text-white bg-primary-600 hover:bg-primary-700 flex items-center gap-2">
                        <i class="ri-add-line"></i> Add Lead
                    </a>
                </div>
            </div>
            <div class="card-header flex flex-wrap items-center justify-between gap-3">
                <div class="flex justify-end items-center gap-2">
                </div>
                <div class="flex justify-end items-center gap-2">
                    <label for="filterFollowUpDate">Follow-Up Date:</label>
                    <input type="date" id="filterFollowUpDate" class="form-control form-control-sm w-auto dark:bg-dark-2 dark:text-white border-neutral-200 dark:border-neutral-500">
                    <button id="searchFollowUpDateBtn" class="btn btn-sm bg-primary-600 text-white">Search</button>
                    <button id="clearFollowUpDateBtn" class="btn btn-sm bg-gray-400 text-white">Clear</button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0" id="leadTable">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="form-check style-check flex items-center gap-2">
                                        <!-- <input class="form-check-input" type="checkbox" id="checkAll"> -->
                                        <label class="form-check-label" for="checkAll">S.L</label>
                                    </div>
                                </th>
                                <!-- <th scope="col">Lead ID</th> -->
                                <th scope="col">Name</th>
                                <th scope="col">Added Date</th>
                                <th scope="col">Follow Up Date</th>
                                <th scope="col">First Response Time</th>
                                <th scope="col">Last Comment</th>
                                <th scope="col">Budget</th>
                                <th scope="col">Assigee</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Assigner</th>
                                <th scope="col">Call Status</th>
                                <th scope="col">Status</th>
                                <th scope="col">Stage</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="leadTableBody">
                            <?php if (!empty($leads)): ?>
                                <?php $i = 1;
                                foreach ($leads as $lead): ?>
                                    <tr data-status="<?= esc($lead['status']) ?>">
                                        <td>
                                            <div class="form-check style-check flex items-center gap-2">
                                                <!-- <input class="form-check-input" type="checkbox" value=""> -->
                                                <label class="form-check-label"><?= $i++; ?></label>
                                            </div>
                                        </td>
                                        <!-- <td><a href="javascript:void(0)" class="text-primary-600">#<?= esc($lead['id']) ?></a></td> -->
                                        <td><?= esc($lead['name']) ?></td>
                                        <td><?= esc(date('d M Y', strtotime($lead['created_at']))) ?></td>
                                        <td><?= esc($lead['follow_up_date']) ?></td>
                                        <td><?= esc($lead['first_response_time']) ?></td>
                                        <td><?= esc($lead['last_comment']) ?></td>
                                        <td><?= esc($lead['budget']) ?></td>
                                        <td><?= esc($lead['assignee']) ?></td>
                                        <td><?= esc($lead['subject']) ?></td>
                                        <td><?= esc($lead['assigner']) ?></td>
                                        <td><?= esc($lead['call_status']) ?></td>
                                        <td>
                                            <?php
                                            $statusClass = match ($lead['status']) {
                                                'New' => 'bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400',
                                                'Contacted' => 'bg-info-100 dark:bg-info-600/25 text-info-600 dark:text-info-400',
                                                'Converted' => 'bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400',
                                                default => 'bg-gray-100 dark:bg-gray-600/25 text-gray-600 dark:text-gray-400'
                                            };
                                            ?>
                                            <span class="update-status <?= $statusClass ?> px-6 py-1.5 rounded-full font-medium text-sm cursor-pointer"
                                                data-id="<?= esc($lead['id']) ?>"
                                                data-status="<?= esc($lead['status']) ?>">
                                                <?= esc($lead['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $stageClass = match ($lead['stage']) {
                                                'Prospect' => 'bg-primary-100 dark:bg-primary-600/25 text-primary-600 dark:text-primary-400',
                                                'Negotiation' => 'bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400',
                                                'Proposal Sent' => 'bg-info-100 dark:bg-info-600/25 text-info-600 dark:text-info-400',
                                                'Won' => 'bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400',
                                                'Lost' => 'bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400',
                                                default => 'bg-gray-100 dark:bg-gray-600/25 text-gray-600 dark:text-gray-400'
                                            };
                                            ?>
                                            <span class="update-stage <?= $stageClass ?> px-6 py-1.5 rounded-full font-medium text-sm cursor-pointer"
                                                data-id="<?= esc($lead['id']) ?>"
                                                data-stage="<?= esc($lead['stage']) ?>">
                                                <?= esc($lead['stage']) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <div class="items-center gap-2">
                                                <a href="<?= base_url('lead_edit/' . $lead['id']) ?>" class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </a>
                                                <a href="<?= base_url('lead/delete/' . $lead['id']) ?>" class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No leads found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Showing Entries & Pagination -->
                <div class="flex flex-wrap items-center justify-between gap-2 mt-6">
                    <span id="showingText">Showing 1 to 10 of <?= count($leads) ?> entries</span>
                    <ul class="pagination flex flex-wrap items-center gap-2 justify-center">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">«</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link active" href="javascript:void(0)">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">»</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-dark-2 p-5 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-medium">Update Lead Status</h3>
        <input type="hidden" id="leadId">
        <select id="newStatus" class="form-select w-full mt-3">
            <option value="New">New</option>
            <option value="Contacted">Contacted</option>
            <option value="Converted">Converted</option>
            <option value="Closed">Closed</option>
        </select>
        <div class="flex justify-end gap-3 mt-4">
            <button id="cancelBtn" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
            <button id="saveStatusBtn" class="bg-primary-600 text-white px-4 py-2 rounded">Save</button>
        </div>
    </div>
</div>



<div id="stageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-dark-2 p-5 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-medium">Update Lead Stage</h3>
        <input type="hidden" id="leadIdStage">
        <select id="newStage" class="form-select w-full mt-3">
            <option value="New">New</option>
            <option value="Prospect">Prospect</option>
            <option value="Negotiation">Negotiation</option>
            <option value="Proposal Sent">Proposal Sent</option>
            <option value="Won">Won</option>
            <option value="Lost">Lost</option>
        </select>
        <div class="flex justify-end gap-3 mt-4">
            <button id="cancelStageBtn" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
            <button id="saveStageBtn" class="bg-primary-600 text-white px-4 py-2 rounded">Save</button>
        </div>
    </div>
</div>


<?= view('partials/layouts/layoutBottom.php'); ?>