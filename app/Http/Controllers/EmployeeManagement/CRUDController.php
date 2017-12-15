<?php

namespace App\Http\Controllers\EmployeeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Employee;
use App\Unit;
use App\Ticket;
use DB;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;


class CRUDController extends Controller
{
	public function showManagementForm ()
	{
		return view('employee.manage');
	}


	protected function add_new_employee(Request $request)
    {
        Employee::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'phone_number' => $request['phone_number'],
            
            'priv_add_employee' => $request['priv_add_employee'],
            'priv_edit_employee' => $request['priv_edit_employee'], 
            'priv_delete_employee' => $request['priv_delete_employee'], 
            'head_unit_id' => '',
            'id_unit' => $request['id_unit'],
            'head_unit_id' => $request['head_unit_id'],      
            'room' => $request['room'],               
            'id_company' => $request['id_company'], 
            'id_role' => 2, 
        ]);

        return(redirect('/employee/management'));
        #return Employee::create($request->all());
    }

    // Add new unit
    protected function add_new_unit(Request $request)
    {
        Unit::create([
            'name' => $request['name'],               
            'id_company' => $request['id_company'], 
        ]);

        return(redirect('/employee/company_units'));   
    }

    protected function create_ticket(Request $request)
    {
    	Ticket::create([
    		'employee_init_id' => $request['employee_init_id'],
    		'unit_to_id' => $request['unit_to_id'],
    		'id_executor' => NULL,
    		'id_priority' => $request['id_priority'],
    		'subject' => $request['subject'],
    		'description' => $request['description'],
    		'id_status' => 1,
    		'id_company' => $request['id_company'],
    	]);

    	return(redirect('/employee/outgoing_tickets'));
    }

    # this function gets all incoming tickets related to user
    protected function getAllIncomingTickets()
    {
    	# This query selects all tickets related to head unit
		if (Auth::user()->head_unit_id != NULL) {
			$tickets = DB::table('employee_tickets')
				->where('id_company', Auth::user()->id_company)
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
			
			$current_executor_name = DB::table('employees')
				->where('id', $ticket->id_executor)
				->select('name')
				->get();

			#this loop gets exatcly the name string from object
			# which was recieved above
			$tmpExecutorName = "Нет исполнителя";
			$tmpCurrentStatusName = NULL;
			foreach ($current_executor_name as $tmp) {
				$tmpExecutorName = $tmp->name;
			}

			# this piece of code selects employee init name by id from ticket
			$current_employee_init_name = DB::table('employees')
				->where('id', $ticket->employee_init_id)
				->select('name')
				->get();

			foreach ($current_employee_init_name as $tmp) {
				$tmpEmployeeInitName = $tmp->name;
			}

			#get status name
			$current_status_name = DB::table('statuses')
				->where('id', $ticket->id_status)
				->select('name')
				->get();

			foreach ($current_status_name as $tmp) {
				$tmpCurrentStatusName = $tmp->name;
			}
			
			
			$tickets[$i]->current_employee_init_name = $tmpEmployeeInitName;
			$tickets[$i]->current_executor_name = $tmpExecutorName;

			$tickets[$i]->current_status_name = $tmpCurrentStatusName;
			$i++;
			
		} 
	
		return view('employee.tickets.view_all_incoming_tickets')
			->with('tickets', $tickets)
			->with('employees', $employees)
			->with('current_executor', $current_executor);
    
    }

    protected function appointExecutorToTicket(Request $request)
    {
    	$id = $request['id_ticket'];
    	$recordToUpdate = Ticket::findOrFail($id);

        DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['id_executor' => $request['id_new_executor']]);

    	return(redirect('/employee/view_all_incoming_tickets'));
    } 


}
