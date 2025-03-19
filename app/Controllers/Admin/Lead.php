<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LeadModel;

class Lead extends BaseController
{
    public function index()
    {
        $leadModel = new LeadModel();
        $data['leads'] = $leadModel->findAll(); // Fetch all leads
        return view('admin/lead/lead_list', $data);
    }

    public function add()
    {
        return view('admin/lead/lead_add'); // View for adding a new lead
    }

    public function save()
    {
        $leadModel = new LeadModel();

        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'        => 'required|string|max_length[255]',
            'email'       => 'required|valid_email|is_unique[leads.email]',
            'phone'       => 'required|string|max_length[20]',
            'stage'       => 'required|in_list[New,Contacted,Qualified,Proposal Sent,Won,Lost]',
            'status'      => 'required|in_list[Open,Closed]',
            'company'     => 'permit_empty|string|max_length[255]',
            'lead_source' => 'permit_empty|string|max_length[255]',
            'assigned_to' => 'permit_empty|string|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Prepare data for insertion
        $leadData = [
            'name'               => $this->request->getPost('name'),
            'email'              => $this->request->getPost('email'),
            'phone'              => $this->request->getPost('phone'),
            'stage'              => $this->request->getPost('stage'),
            'status'             => $this->request->getPost('status'),
            'company'            => $this->request->getPost('company'),
            'lead_source'        => $this->request->getPost('lead_source'),
            'assigned_to'        => $this->request->getPost('assigned_to'),
            'follow_up_date'     => $this->request->getPost('follow_up_date'),
            'first_response_time'=> $this->request->getPost('first_response_time'),
            'last_comment'       => $this->request->getPost('last_comment'),
            'budget'             => $this->request->getPost('budget'),
            'assignee'           => $this->request->getPost('assignee'),
            'subject'            => $this->request->getPost('subject'),
            'assigner'           => $this->request->getPost('assigner'),
            'call_status'        => $this->request->getPost('call_status'),
        ];

        // Insert data into the database
        if ($leadModel->insert($leadData)) {
            return redirect()->to(base_url('leads'))->with('success', 'Lead added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add lead.');
        }
    }




    public function edit($id)
    {
        $leadModel = new LeadModel();
        $lead = $leadModel->find($id);

        if (!$lead) {
            return redirect()->to(base_url('leads'))->with('error', 'Lead not found.');
        }

        return view('admin/lead/lead_edit', ['lead' => $lead]);
    }

    public function update($id)
    {
        $leadModel = new LeadModel();

        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'  => 'required|string|max_length[255]',
            'email' => "required|valid_email|is_unique[leads.email,id,{$id}]",
            'phone' => 'required|string|max_length[20]',
            'stage' => 'required|in_list[New,Contacted,Qualified,Proposal Sent,Won,Lost]',
            'status' => 'required|in_list[Open,Closed]',
            'company' => 'permit_empty|string|max_length[255]',
            'lead_source' => 'permit_empty|string|max_length[255]',
            'assigned_to' => 'permit_empty|string|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Prepare data for update
        $leadData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'stage' => $this->request->getPost('stage'),
            'status' => $this->request->getPost('status'),
            'company' => $this->request->getPost('company'),
            'lead_source' => $this->request->getPost('lead_source'),
            'assigned_to' => $this->request->getPost('assigned_to'),
        ];

        // Update lead in database
        if ($leadModel->update($id, $leadData)) {
            return redirect()->to(base_url('leads'))->with('success', 'Lead updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update lead.');
        }
    }


    public function delete($id)
    {
        // Logic to delete a lead
    }

    public function update_status()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON();
            $leadId = $json->lead_id;
            $newStatus = $json->status;
            $leadModel = new LeadModel();
            $leadModel->update($leadId, ['status' => $newStatus]);

            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    public function update_stage()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON();
            $leadId = $json->lead_id;
            $newStage = $json->stage;
            $leadModel = new LeadModel();
            $leadModel->update($leadId, ['stage' => $newStage]);

            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
    }
}
