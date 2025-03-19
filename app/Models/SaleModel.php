<?php

namespace App\Models;

class SaleModel extends BaseModel
{
    protected $table = 'sales';
    protected $allowedFields = ['customer_id', 'total_amount', 'status', 'invoice_number', 'created_at'];
}
