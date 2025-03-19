<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $table;   // Table name (set in child model)
    protected $primaryKey = 'id';
    protected $allowedFields = []; // Fields that can be inserted or updated

    /**
     * Get all records from the table
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * Get a single record by ID
     */
    public function getById($id)
    {
        return $this->find($id);
    }

    /**
     * Insert a new record
     */
    public function insertData($data)
    {
        return $this->insert($data);
    }

    /**
     * Update an existing record
     */
    public function updateData($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a record by ID
     */
    public function deleteData($id)
    {
        return $this->delete($id);
    }
}
