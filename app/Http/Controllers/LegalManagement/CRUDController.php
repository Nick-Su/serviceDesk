<?php

namespace App\Http\Controllers\LegalManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Legal;
use App\LegalTicket;

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
		$allCompanies = DB::table('about_company')
					->where('city', Auth::user()->city)
					->where('external_tickets', 1)
					->get();

		return view('legal.tickets.view_all_companies')
				->with('allCompanies', $allCompanies);
	}

	#
	# Shows the create ticket form
	#
	public function showCreateTicketForm ($id_company)
	{
		$allUnitsOfTheCompany = self::getAllUnits($id_company);

		$allPriorities = self::getAllPriorities();

		$company = DB::table('about_company')
						->where('id_company', $id_company)
						->get();

		$client = DB::table('individuals')
						->where('id', Auth::user()->id)
						->get();

		foreach ($client as $key) {
			$clientAddress = $key->address;
		}

		foreach ($company as $key) {
			$tmpCompanyName = $key->name;
			$tmpCompanyId = $key->id_company;
		}

		return view('legal.tickets.create_ticket')
			->with('allUnitsOfTheCompany', $allUnitsOfTheCompany)
			->with('allPriorities', $allPriorities)
			->with('CompanyName', $tmpCompanyName)
			->with('CompanyId', $tmpCompanyId)
			->with('clientAddress', $clientAddress);
	}

	#
	# Create ticket
	#
	public function createTicket (Request $request)
	{
		LegalTicket::create([
    		'id_client' => $request['id_client'],
    		'id_company_to' => $request['id_company'],
    		'unit_to_id' => $request['unit_to_id'],

    		'id_priority' => $request['id_priority'],
    		'subject' => $request['subject'],
    		'description' => $request['description'],
    		'address' => $request['client_address'],
    		
    		'id_status' => 1,
    		'id_executor' => NULL,
    	]);

    	return(redirect('/legal/outgoing_tickets'));
	}

	#
	# Show outgoing tickets page
	#
	public function showOutgoingTickets()
	{
		$tickets = DB::table('legal_tickets')
                ->orderBy('id_priority', 'desc')
				->where('id_client', Auth::user()->id)
				->where('id_status', '<>', 2)
				->where('id_status', '<>', 7)     
				->get(); 

       # This algorithm select the name of current executor by id
		$current_executor = [];
		$current_employee_init_name = "";
		$i=0;

		foreach($tickets as $ticket) {
			# get the company name
			$companyName = self::getCompanyName($ticket->id_company_to);

			$tmpExecutorName = self::getExecutorName($ticket->id_executor);
			#$tmpEmployeeInitName = self::getClientInitName($ticket->id_client);
			$tmpCurrentStatusName = self::getStatusName($ticket->id_status);
			
			$tickets[$i]->companyName = $companyName;
			$tickets[$i]->current_executor_name = $tmpExecutorName;
			$tickets[$i]->current_status_name = $tmpCurrentStatusName;
			$tickets[$i]->priority = $ticket->id_priority;
			$i++;			
		} 

		return view('legal.tickets.view_outgoing_tickets', compact('tickets'));
				
	}

	#
	# Mark individual ticket as incomplete
	#
	protected function legalTicketIsNotComplete($id)
	{
		(int) $id;
		$recordToUpdate = LegalTicket::findOrFail($id);
		DB::table('legal_tickets')
            ->where('id', $id)
            ->update(['id_status' => 1, 'id_executor' => NULL]);

        return(redirect('/legal/outgoing_tickets'));
	} 

	#
    # confirm ticket by Initiator
    #
	protected function legalTicketCompleteByInitiator($id)
	{
		(int) $id;
		$recordToUpdate = LegalTicket::findOrFail($id);
		DB::table('legal_tickets')
            ->where('id', $id)
            ->update(['confirmed_by_initiator' => True, 'id_status' => 6]);

        self::checkLegalTicketBothConfiramtion($id);

        return(redirect('/legal/outgoing_tickets'));
	}

	#
    # This function show additional info about individual ticket
	#
	protected function moreInfoLegalTicket($id)
	{
		(int) $id;
		
		$ticketInfo = DB::table('legal_tickets')
            ->where('id', $id)
            ->get();

        foreach ($ticketInfo as $ticket) {
        	$executorName = self::getExecutorName($ticket->id_executor);
        	$statusName = self::getStatusName($ticket->id_status);
        }

        # get prio name
        $prioName = self::getPriority($ticket->id_priority);
        

        # get unit name
        $allUnits = self::getUnits($ticket->unit_to_id);
        foreach ($allUnits as $unit) {
        	$unitName = $unit->name;
        }

        # get client init name
        $clientName = self::getClientInitName($ticket->id_client);

        #get client
        $client = self::getFullClient($ticket->id_client);

        foreach ($client as $key) {
        	$clientEmail = $key->email; 
        	$clientTel = $key->phone_number;
        }

        return view('legal.tickets.more_info_legal_ticket')
        			->with('ticketInfo', $ticketInfo)
        			->with('statusName', $statusName)
        			->with('prioName', $prioName)
        			->with('unitName', $unitName)
        			->with('clientName', $clientName)
        			->with('clientEmail', $clientEmail)
        			->with('clientTel', $clientTel)
        			->with('executorName', $executorName);
	}






	#
	# shows the profile page
	#
    public function showProfilePage()
    {
    	$about_legal_client = DB::table('legals')
					->where('id', Auth::user()->id)
					->get();

		$tmpClientName = NULL;
		$tmpCity = NULL;
		$tmpAddress = NULL;
		$tmpEmail = NULL;
		$tmpTel = NULL;

		foreach($about_legal_client as $info) {
			$tmpClientName = $info->name;
			$tmpCity = $info->city;
			$tmpAddress = $info->address;
			$tmpEmail = $info->email;
			$tmpTel = $info->phone_number;
		}

		return view('legal.my_profile')
				->with('name', $tmpClientName)
    			->with('city', $tmpCity)
    			->with('address', $tmpAddress)
    			->with('email', $tmpEmail)
    			->with('tel', $tmpTel);
    }

    #
	# Profile indo filler
	#
	public function saveProfileInfo(Request $request)
	{
		DB::table('legals')
			->where('id', Auth::user()->id)
			->update([
				'name' => $request['name'], 
				'city' => $request['city'],
				'address' => $request['address'],  
				'email' => $request['email'],
				'phone_number' => $request['tel'], 
			]);            
		
		return(redirect('/legal/profile')); ;
	}








	##################################################################
	#************  Function helpers 				*****************
	#################################################################

	#
	#	This func check executor & initiator confirmation & and if both
	#	confirmed, it close the Individual ticket.
	#
	protected function checkLegalTicketBothConfiramtion($id)
	{	
		(int) $id;
		$recordToUpdate = LegalTicket::findOrFail($id);
		$tmpValues = DB::table('individual_tickets')
            ->where('id', $id)
            ->select('confirmed_by_executor', 'confirmed_by_initiator')
            ->get();
        
        foreach ($tmpValues as $value) {
            	if( $value->confirmed_by_executor == 1 && $value->confirmed_by_initiator == 1)
            	{
            		DB::table('individual_tickets')
			            ->where('id', $id)
			            ->update(['id_status' => 7]);
            	}
            }    

		return;
	}

	#
	# get priority. It returns priority object with all fields
	#
	private function getAllPriorities()
	{
		return DB::table('priorities')->get();
	}

	#
	# get all units of the company
	#
	private function getAllUnits($id_company)
	{
		return DB::table('units')
				->where('id_company', $id_company)
				->get();
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
	# get info of the company
	#
	private function getCompanyInfo($id_company)
	{
		return DB::table('about_company')
				->where('id_company', $id_company)
				->get();
	}

	#
	# get company name
	#
	private function getCompanyName($id_company_to)
	{
		$tmpInfo = DB::table('about_company')
				->where('id_company', $id_company_to)
				->select('name')
				->get();
		
		foreach ($tmpInfo as $key) {
			$companyName = $key->name;
		}

		return $companyName;
	}

	#
	# get the name of current excutor
	#
	private function getCurrentExecutor($id_executor)
	{
		$executorName = '';
		$tmpExecutorName = DB::table('employees')
				->where('id', $id_executor)
				->select('name')
				->get();
		
		foreach ($tmpExecutorName as $key) {
			$executorName = $key->name;
		}

		return $executorName;
	}
	
	#
	# get the prio name
	#
	private function getPriorityName($id_priority)
	{
		$tmpPrio = DB::table('priorities')
				->where('id', $id_priority)
				->select('name')
				->get();
		
		foreach ($tmpPrio as $key) {
			$priorityName = $key->name;
		}

		return $priorityName;
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
	# get priority. It returns priority object with all fields
	#
	private function getPriority($id)
	{	
		$prioName = '';
		$priority = DB::table('priorities')
				->where('id', $id)
				->get();
		foreach ($priority as $prio) {
        	$prioName = $prio->name;
        }
        return $prioName;
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
	# Get client name
	#
	protected function getClientInitName($id)
	{
		$client = DB::table('individuals')
			->where('id', $id)
			->get();
		foreach ($client as $key) {
			$clientName = $key->name;
		}
		return $clientName;
	}

	#
	# Get client name
	#
	protected function getFullClient($id)
	{
		$client = DB::table('individuals')
			->where('id', $id)
			->get();
		
		return $client;
	}
}
