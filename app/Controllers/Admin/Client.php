<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientModel;

class Client extends BaseController
{
    public function index()
    {
        $clientModel = new ClientModel();
        $data['clients'] = $clientModel->findAll();

        return view('admin/client/client_list', $data);
    }


    public function add()
    {
        $data = [
            'title' => 'Add Client',
            'subTitle' => 'Client Management',
        ];
        return view('admin/client/client_add', $data);
    }


    public function save()
    {
        $clientModel = new ClientModel();

        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'              => 'required|string|max_length[255]',
            'email'             => 'required|valid_email|is_unique[clients.email]',
            'phone'             => 'required|string|max_length[20]',
            'company'           => 'permit_empty|string|max_length[255]',
            'address'           => 'permit_empty|string',
            'city'              => 'permit_empty|string|max_length[100]',
            'state'             => 'permit_empty|string|max_length[100]',
            'zip_code'          => 'permit_empty|string|max_length[20]',
            'country'           => 'permit_empty|string|max_length[100]'
        ]);

        if (!empty($this->request->getPost('project_live_date'))) {
            $validation->setRule('project_live_date', 'Project Live Date', 'valid_date');
        }

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Prepare data for insertion
        $clientData = [
            'name'              => $this->request->getPost('name'),
            'email'             => $this->request->getPost('email'),
            'phone'             => $this->request->getPost('phone'),
            'company'           => $this->request->getPost('company'),
            'address'           => $this->request->getPost('address'),
            'city'              => $this->request->getPost('city'),
            'state'             => $this->request->getPost('state'),
            'zip_code'          => $this->request->getPost('zip_code'),
            'country'           => $this->request->getPost('country'),
            'project_live_date' => $this->request->getPost('project_live_date') ?: null,
        ];

        // Insert data into the database
        if ($clientModel->insert($clientData)) {
            return redirect()->to(base_url('clients'))->with('success', 'Client added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add client.');
        }
    }


    public function edit($id)
    {
        $clientModel = new ClientModel();
        $client = $clientModel->find($id);

        if (!$client) {
            return redirect()->to('clients')->with('error', 'Client not found');
        }

        return view('admin/client/client_edit', ['client' => $client]);
    }

    public function update($id)
    {

        $clientModel = new ClientModel();

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'company' => 'permit_empty',
            'address' => 'permit_empty',
            'city' => 'permit_empty',
            'state' => 'permit_empty',
            'zip_code' => 'permit_empty',
            'country' => 'permit_empty',
        ]);

        if (!empty($this->request->getPost('project_live_date'))) {
            $validation->setRule('project_live_date', 'Project Live Date', 'valid_date');
        }

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        // Get data from form
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'company' => $this->request->getPost('company'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zip_code' => $this->request->getPost('zip_code'),
            'country' => $this->request->getPost('country'),
            'project_live_date' => $this->request->getPost('project_live_date'),
        ];

        // Update client in database
        if ($clientModel->update($id, $data)) {
            return redirect()->to('clients')->with('success', 'Client updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update client');
        }
    }


    public function delete($id)
    {
        $clientModel = new \App\Models\ClientModel();

        // Check if client exists
        $client = $clientModel->find($id);
        if (!$client) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Client not found!'
            ]);
        }

        // Delete the client
        if ($clientModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Client deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete client.'
            ]);
        }
    }
}
