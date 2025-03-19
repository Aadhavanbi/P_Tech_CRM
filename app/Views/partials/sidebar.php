<aside class="sidebar">
    <button type="button" class="sidebar-close-btn !mt-4">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="<?= base_url('dashboard') ?>" class="sidebar-logo">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="site logo" class="light-logo">
            <img src="<?= base_url('assets/images/logo-light.png') ?>" alt="site logo" class="dark-logo">
            <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="<?= base_url('dashboard') ?>">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:shopping-outline" class="menu-icon"></iconify-icon>
                    <span>Sales</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Invoice</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= base_url('invoice') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                    </li>
                    <li>
                        <a href="<?= base_url('invoice_add') ?>"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Add new</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:file-document-edit-outline" class="menu-icon"></iconify-icon>
                    <span>Quote</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= base_url('quote') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                    </li>
                    <li>
                        <a href="<?= base_url('quote_add') ?>"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Add new</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:account-group-outline" class="menu-icon"></iconify-icon>
                    <span>Leads</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= base_url('leads') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                    </li>
                    <li>
                        <a href="<?= base_url('lead_add') ?>"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Add new</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:badge-account-outline" class="menu-icon"></iconify-icon>
                    <span>Employee Management</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= base_url('employees') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                    </li>
                    <li>
                        <a href="<?= base_url('employee_add') ?>"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Add Employee</a>
                    </li>
                </ul>
            </li>
            <!-- Client Management -->
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:account-multiple-outline" class="menu-icon"></iconify-icon>
                    <span>Client Management</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= base_url('clients') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Client List</a>
                    </li>
                    <li>
                        <a href="<?= base_url('client_add') ?>"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Add Client</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>