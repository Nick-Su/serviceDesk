<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $table = "about_company";

    protected $fillable = [
        'name', 'city', 'address', 'email', 'tel', 'description', 'external_tickets', 'id_company',
    ];
}
