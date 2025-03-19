<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices'; // Table name
    protected $primaryKey = 'id'; // Primary key

    protected $allowedFields = [
        'client_id',
        'quote_id',
        'invoice_date',
        'due_date',
        'subtotal',
        'discount',
        'tax',
        'total_amount',
        'status',
        'paid_amount',
        'due_amount',
        'order_id',
        'shipment_id',
        'created_at',
        'updated_at'
    ];
}
