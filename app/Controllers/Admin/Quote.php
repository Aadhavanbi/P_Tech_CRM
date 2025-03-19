<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\QuoteModel;
use App\Models\ClientModel;

class Quote extends BaseController
{
    public function index()
    {
        $quoteModel = new QuoteModel();
        $clientModel = new ClientModel(); // Fetch client details if needed

        // Fetch all quotes
        $quotes = $quoteModel->findAll();

        // Fetch client names
        foreach ($quotes as &$quote) {
            $client = $clientModel->find($quote['client_id']);
            $quote['client_name'] = $client ? $client['name'] : 'Unknown';
        }

        return view('admin/quote/quote_list', ['quotes' => $quotes]);
    }

    public function preview()
    {
        return view('admin/quote/quote_preview');
    }

    public function add()
    {
        $clientModel = new \App\Models\ClientModel();
        $data['clients'] = $clientModel->findAll(); // Fetch all clients
        return view('admin/quote/quote_add', $data); // Return the correct view
    }


    public function store()
    {
        // Logic to save quote
    }

    public function edit($id)
    {
        return view('admin/quote/quote_edit', ['id' => $id]);
    }

    public function update($id)
    {
        // Logic to update quote
    }

    public function delete($id)
    {
        // Logic to delete quote
    }
}
