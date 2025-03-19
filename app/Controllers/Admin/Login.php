<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        return view('admin/login'); // Ensure this view exists in "app/Views/admin/login.php"
    }
}
