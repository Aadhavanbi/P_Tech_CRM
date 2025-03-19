<?php

namespace App\Models;


class ClientModel extends BaseModel
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'company', 'address', 'city', 'state', 'zip_code', 'country','project_live_date', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
