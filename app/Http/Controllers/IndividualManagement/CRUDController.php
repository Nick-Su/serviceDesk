<?php

namespace App\Http\Controllers\IndividualManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Individul;
use App\IndividualTicket;

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

		return view('individual.tickets.view_all_companies')
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

		return view('individual.tickets.create_ticket')
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
		IndividualTicket::create([
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

    	return(redirect('/individual/outgoing_tickets'));
	}

	#
	# Show outgoing tickets page
	#
	public function showOutgoingTickets()
	{
		return view('individual.tickets.view_outgoing_tickets');
	}



	#
	# show profile page
	#
	public function showProfileForm()
	{
		$about_indi_client = DB::table('individuals')
					->where('id', Auth::user()->id)
					->get();

		$tmpClientName = NULL;
		$tmpCity = NULL;
		$tmpAddress = NULL;
		$tmpEmail = NULL;
		$tmpTel = NULL;

		foreach($about_indi_client as $info) {
			$tmpClientName = $info->name;
			$tmpCity = $info->city;
			$tmpAddress = $info->address;
			$tmpEmail = $info->email;
			$tmpTel = $info->phone_number;
		}

		return view('individual.my_profile')
				->with('name', $tmpClientName)
    			->with('city', $tmpCity)
    			->with('address', $tmpAddress)
    			->with('email', $tmpEmail)
    			->with('tel', $tmpTel);
	}

	#
	# Profile filler
	#
	public function saveProfileInfo(Request $request)
	{
		DB::table('individuals')
			->where('id', Auth::user()->id)
			->update([
				'name' => $request['name'], 
				'city' => $request['city'],
				'address' => $request['address'],  
				'email' => $request['email'],
				'phone_number' => $request['tel'], 
			]);            
		
		return(redirect('/individual/my_profile')); ;
	}


	##################################################################
	#************  Function helpers 				*****************
	#################################################################

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
	# get info of the company
	#
	private function getCompanyInfo($id_company)
	{
		return DB::table('about_company')
				->where('id_company', $id_company)
				->get();
	}


	

}
