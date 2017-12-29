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
	#
	# Shows management form
	#
	public function showManagementForm ()
	{
		return view('employee.manage');
	}

	#
	# Create new employee
	#
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

	#
    # Add new unit
    #
    protected function add_new_unit(Request $request)
    {
        Unit::create([
            'name' => $request['name'],               
            'id_company' => $request['id_company'], 
        ]);

        return(redirect('/employee/company_units'));   
    }
    /////////////////////////////////////////
    #		Ticket functions
    /////////////////////////////////////////////
    
    protected function showCreateTicketForm()
    {
    	$units = DB::table('units')->where('id_company', Auth::user()->id_company)->get();
	
		$employees = DB::table('employees')
					->where('id_company', Auth::user()->id_company)
					->where('id_unit', Auth::user()->id_unit)
					->get();

		$priorities = DB::table('priorities')->get();

		return view('employee.tickets.create_ticket')
				->with('units', $units)
				->with('employees', $employees)
				->with('priorities', $priorities);
    }


    #
    # This func create ticket
   	#
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


    #
    # this function gets all incoming tickets related to user
    #
    protected function getAllIncomingTickets()
    {
    	# This query selects all tickets related to head unit
		if (Auth::user()->head_unit_id != NULL) {
			$tickets = DB::table('employee_tickets')		
				->where('id_company', Auth::user()->id_company)
				->where('id_status', '<>', 2)
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
	
		return view('employee.tickets.view_all_incoming_tickets')
			->with('tickets', $tickets)
			->with('employees', $employees)
			->with('current_executor', $current_executor);
    
    }

    #
    # This func gets all outgoing tickets
    #
    protected function getAllOutgoingTickets()
    {
    	# This query selects all tickets related to head unit
		
		# This query selects all tickets related to head unit
		
		$tickets = DB::table('employee_tickets')		
			->where('id_company', Auth::user()->id_company)
			->where('id_status', '<>', 2)
			->where('employee_init_id', Auth::user()->id)		
			->get(); 


		# This query selects all employees of single unit
		$employees = DB::table('employees')
			->where('id_company', Auth::user()->id_company)
			->where('id_unit', Auth::user()->head_unit_id)
			->get();

		

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

		return view('employee.tickets.outgoing_tickets')
				->with('tickets', $tickets)
				->with('employees', $employees);
			#->with('current_executor', $current_executor);
		
    }


    #
    # This func checks ticket's status & if it's <> 0 it will set status 3
    #
    public function checkTicketStatus($id_ticket)
    {

    	DB::table('employee_tickets')
    		->where('id', $id_ticket)
    		->having('id_executor', '>', 0)
    		->update(['id_status' => 3]);
    }

    #
    # This func appoint exeecutor to the ticket
    #
    protected function appointExecutorToTicket(Request $request)
    {
    	$id = $request['id_ticket'];
    	$recordToUpdate = Ticket::findOrFail($id);

        DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['id_executor' => $request['id_new_executor']]);

        # вызов функции для автоматической проверки и изменения статуса   
        self::checkTicketStatus($id);
    	
    	return(redirect('/employee/view_all_incoming_tickets'));
    }

    #
    # This function makes rejection of ticket by setting status 2
	#
	protected function rejectTicket($id)
	{
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['id_status' => 2]);

        return(redirect('/employee/view_all_incoming_tickets'));
	}

	#
    # This function show additional info about ticket
	#
	protected function moreInfoTicket($id)
	{
		(int) $id;
		
		$ticketInfo = DB::table('employee_tickets')
            ->where('id', $id)
            ->get();

        foreach ($ticketInfo as $ticket) {
        	$executorName = self::getExecutorName($ticket->id_executor);
        	$statusName = self::getStatusName($ticket->id_status);
        }

        # get prio name
        $priority = self::getPriority($ticket->id_priority);
        foreach ($priority as $prio) {
        	$prioName = $prio->name;
        }

        # get unit name
        $allUnits = self::getUnits($ticket->unit_to_id);
        foreach ($allUnits as $unit) {
        	$unitName = $unit->name;
        }

        # get employee init name
        $allEmployyes = self::getAllEmployees($ticket->employee_init_id);
        foreach ($allEmployyes as $employee) {
        	$employeeName = $employee->name;
        }

        return view('employee.tickets.more_info_ticket')
        			->with('ticketInfo', $ticketInfo)
        			->with('statusName', $statusName)
        			->with('prioName', $prioName)
        			->with('unitName', $unitName)
        			->with('employeeName', $employeeName)
        			->with('executorName', $executorName);
	}

	#
    # This function reopen ticket
	#
	protected function reopenTicket($id)
	{
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['id_status' => 1, 'id_executor' => NULL]);

        return(redirect('/employee/view_all_incoming_tickets'));
	}

	#
	# This func marks ticket as processing
	#
	protected function takeTheTicket($id)
	{
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['id_status' => 4]);

        return(redirect('/employee/view_all_incoming_tickets'));
	}

	#
	# This func refuse the ticket
	#
	protected function refuseTheTicket($id)
	{
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['id_executor' => NULL, 'id_status' => 1]);

        return(redirect('/employee/view_all_incoming_tickets'));
	}

	#
	# This func marks ticket as completed by executor
	#
	protected function ticketComplete($id)
	{
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['confirmed_by_executor' => True, 'id_status' => 5]);

        self::checkTicketBothConfiramtion($id);

        return(redirect('/employee/view_all_incoming_tickets'));
	}
     
	protected function ticketCompleteByInitiator($id)
	{
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['confirmed_by_initiator' => True, 'id_status' => 6]);

        self::checkTicketBothConfiramtion($id);

        return(redirect('/employee/outgoing_tickets'));
	}

	protected function ticketIsNotComplete($id)
	{
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		DB::table('employee_tickets')
            ->where('id', $id)
            ->update(['id_status' => 1, 'id_executor' => NULL]);

        return(redirect('/employee/outgoing_tickets'));
	}

	#######################################################################
	#############			 Functions helpers				  ############
	######################################################################

	#
	#	This func check executor & initiator confirmation & and if both
	#	confirmed, it close the ticket.
	#
	protected function checkTicketBothConfiramtion($id)
	{	
		(int) $id;
		$recordToUpdate = Ticket::findOrFail($id);
		$tmpValues = DB::table('employee_tickets')
            ->where('id', $id)
            ->select('confirmed_by_executor', 'confirmed_by_initiator')
            ->get();
        
        foreach ($tmpValues as $value) {
            	if( $value->confirmed_by_executor == 1 && $value->confirmed_by_initiator == 1)
            	{
            		DB::table('employee_tickets')
			            ->where('id', $id)
			            ->update(['id_status' => 7]);
            	}
            }    


     
		return;
	}

	#
	# get executor name
	#
	protected function getExecutorName($id)
    {
    	$current_executor_name = DB::table('employees')
				->where('id', $id)
				->select('name')
				->get();

		#this loop gets exatcly the name string from object
		# which was recieved above
		$tmpExecutorName = "Нет исполнителя";
		$tmpCurrentStatusName = NULL;
		foreach ($current_executor_name as $tmp) {
			$tmpExecutorName = $tmp->name;
		}
		return $tmpExecutorName;
    }

    #
    # Get employee init name
    #
    protected function getEmployeeInitName($id)
    {
    	$current_employee_init_name = DB::table('employees')
    		->where('id', $id)
    		->select('name')
    		->get();

    	foreach ($current_employee_init_name as $tmp) {
    		$tmpEmployeeInitName = $tmp->name;
    	}
    	return $tmpEmployeeInitName;
    }

    #
    # get status name
    #
    protected function getStatusName($id) 
    {
		$current_status_name = DB::table('statuses')
			->where('id', $id)
			->select('name')
			->get();

		foreach ($current_status_name as $tmp) {
			$tmpCurrentStatusName = $tmp->name;
		}

		return $tmpCurrentStatusName;
	}

	#
	# get priority. It returns prioritu object with all fields
	#
	private function getPriority($id)
	{
		return DB::table('priorities')
				->where('id', $id)
				->get();
	}

	#
	# get all units
	#
	protected function getUnits($id)
	{
		return DB::table('units')
				->where('id', $id)
				->get();
	}

	#
	# get all employees
	#
	protected function getAllEmployees($id)
	{
		return DB::table('employees')
				->where('id', $id)
				->get();
	}
}
