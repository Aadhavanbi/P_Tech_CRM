<?php

namespace App\Models;

class EmployeeModel extends BaseModel
{
    protected $table = 'employees';
    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'position',
        'salary',
        'status',
        'created_at',
        'updated_at'
    ];
}
