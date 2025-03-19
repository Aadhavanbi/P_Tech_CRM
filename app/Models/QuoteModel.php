<?php

namespace App\Models;

class QuoteModel extends BaseModel
{
    protected $table = 'quotes';
    protected $allowedFields = ['client_id', 'quote_date', 'quote_no', 'expiry_date', 'total_amount', 'status'];
}
