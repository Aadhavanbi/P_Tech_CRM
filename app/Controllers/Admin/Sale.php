<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Sale extends BaseController
{
    public function index()
    {
        return view('admin/sales_list'); // View for listing sales
    }

    public function add()
    {
        return view('admin/sale_add'); // View for adding a new sale
    }

    public function store()
    {
        // Logic to save a new sale
    }

    public function edit($id)
    {
        return view('admin/sale_edit', ['id' => $id]); // View for editing a sale
    }

    public function update($id)
    {
        // Logic to update sale details
    }

    public function delete($id)
    {
        // Logic to delete a sale
    }
}
