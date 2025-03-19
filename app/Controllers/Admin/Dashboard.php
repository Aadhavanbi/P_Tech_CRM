<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('admin/dashboard'); // Ensure this view exists in "app/Views/admin/dashboard.php"
    }
}
