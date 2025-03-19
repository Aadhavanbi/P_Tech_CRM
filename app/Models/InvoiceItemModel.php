<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceItemModel extends Model
{
    protected $table            = 'invoice_items';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['invoice_id', 'item_name','description', 'quantity','unit', 'unit_price', 'total_price'];

    // Calculate total price before inserting
    protected function beforeInsert(array $data)
    {
        if (isset($data['data']['quantity']) && isset($data['data']['unit_price'])) {
            $data['data']['total_price'] = $data['data']['quantity'] * $data['data']['unit_price'];
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        return $this->beforeInsert($data);
    }
}
