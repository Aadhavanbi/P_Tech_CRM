<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;

class Employee extends BaseController
{
    public function index()
    {
        $employeeModel = new EmployeeModel();
        $employees = $employeeModel->findAll(); // Fetch all employees from DB

        return view('admin/employee/employee_list', ['employees' => $employees]);
    }

    public function add()
    {
        return view('admin/employee/employee_add');
    }

    public function save()
    {
        $employeeModel = new EmployeeModel();
        $file = $this->request->getFile('photo');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName(); // Generate a random name for the image
            $file->move('uploads/employees', $newName); // Move to public/uploads/employees
        } else {
            $newName = null; // No file uploaded
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'phone'    => $this->request->getPost('phone'),
            'position' => $this->request->getPost('position'),
            'salary'   => $this->request->getPost('salary'),
            'status'   => $this->request->getPost('status'),
            'photo'    => $newName, // Save only the filename, not full path
        ];

        $employeeModel->insert($data);
        return redirect()->to('/employees')->with('success', 'Employee added successfully');
    }



    public function edit($id)
    {
        $model = new EmployeeModel();
        $data['employee'] = $model->find($id);

        return view('admin/employee/employee_edit', $data);
    }

    public function update($id)
    {
        $employeeModel = new EmployeeModel();

        // Fetch employee
        $employee = $employeeModel->find($id);
        if (!$employee) {
            return redirect()->to(base_url('employees'))->with('error', 'Employee not found.');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'   => 'required|string|max_length[255]',
            'email'  => 'required|valid_email|is_unique[employees.email,id,' . $id . ']',
            'phone'  => 'required|string|max_length[20]',
            'position' => 'permit_empty|string|max_length[100]',
            'salary' => 'permit_empty|decimal',
            'status' => 'required|in_list[Active,Inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Update data
        $employeeData = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'phone'  => $this->request->getPost('phone'),
            'position' => $this->request->getPost('position'),
            'salary' => $this->request->getPost('salary'),
            'status' => $this->request->getPost('status'),
        ];

        if ($employeeModel->update($id, $employeeData)) {
            return redirect()->to(base_url('employees'))->with('success', 'Employee updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update employee.');
        }
    }


    // public function delete($id)
    // {
    //     $model = new EmployeeModel();
    //     $model->delete($id);

    //     return redirect()->to('employees')->with('success', 'Employee deleted successfully');
    // }
}
