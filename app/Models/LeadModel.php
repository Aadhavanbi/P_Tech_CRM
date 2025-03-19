<?php

namespace App\Models;
use CodeIgniter\Model;

class LeadModel extends BaseModel
{
    protected $table = 'leads';
    protected $allowedFields = [
        'name', 
        'email', 
        'phone', 
        'company', 
        'lead_source', 
        'assigned_to', 
        'stage', 
        'status',
        'follow_up_date', 
        'first_response_time', 
        'last_comment', 
        'budget', 
        'assignee', 
        'subject', 
        'assigner', 
        'call_status'
    ];
}
