<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $table = 'employee_tickets';
	
    protected $fillable = [
        'employee_init_id', 'unit_to_id', 'id_executor',  'id_priority', 'subject', 'description', 'id_status', 'id_company', 
    ];
}
