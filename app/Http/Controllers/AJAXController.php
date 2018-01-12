<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Employee;
use App\Unit;
use App\Ticket;
use App\IndividualTicket;
use App\LegalTicket;
use App\Company;

use DB;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class AJAXController extends Controller
{
  public function index()
  {
   // $items = Ticket::all();
   // return view('employee.tickets.view_all_incoming_inner_tickets', compact('items')); // pass items to view


  	# This query selects all tickets related to head unit
		if (Auth::user()->head_unit_id != NULL) {
			$tickets = DB::table('employee_tickets')		
				->where('id_company', Auth::user()->id_company)
				->where('id_status', '<>', 2)
				->where('id_status', '<>', 7)
				->where('unit_to_id', Auth::user()->head_unit_id)		
				->get(); 


		# This query selects all employees of single unit
		$employees = DB::table('employees')
			->where('id_company', Auth::user()->id_company)
			->where('id_unit', Auth::user()->head_unit_id)
			->get();

		} else { 
			# this query selects all tickets related to executor
			$tickets = DB::table('employee_tickets')
				->where('id_company', Auth::user()->id_company)
				->where('id_executor', Auth::user()->id)
				->get();
			$employees = NULL;
		}

		# This algorithm select the name of current executor by id
		$current_executor = [];
		$current_employee_init_name = "";
		$i=0;

		foreach($tickets as $ticket) {
			
			$tmpExecutorName = self::getExecutorName($ticket->id_executor);
			$tmpEmployeeInitName = self::getEmployeeInitName($ticket->employee_init_id);
			$tmpCurrentStatusName = self::getStatusName($ticket->id_status);
			
			$tickets[$i]->current_employee_init_name = $tmpEmployeeInitName;
			$tickets[$i]->current_executor_name = $tmpExecutorName;
			$tickets[$i]->current_status_name = $tmpCurrentStatusName;
			$i++;
			
		} 
	
		return view('employee.tickets.view_all_incoming_tickets', compact('tickets', 'employees', 'current_executor')) ;
			//->with('tickets', $tickets)
			//->with('employees', $employees)
			//->with('current_executor', $current_executor);

  }
}
