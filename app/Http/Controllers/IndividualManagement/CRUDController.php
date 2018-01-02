<?php

namespace App\Http\Controllers\IndividualManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Individul;
use App\Http\Controllers\IndividualManagement;
use DB;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class CRUDController extends Controller
{
	#
	# Shows the starter page for creation form for ticket
	#
    public function showAvailableCompaniesForm ()
	{
		return view('individual.tickets.view_all_companies');
	}
}
