<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('employee')->user();

    return view('employee.home');
})->name('home');


Route::get('/management', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('employee')->user();

    return view('employee.manage');
}); 

Route::get('/create_employee', function () {
	$units = DB::table('units')->where('id_company', Auth::user()->id_company)->get();
    return view('employee.create')->with('units', $units);
});

Route::get('/company_profile', function () {
    return view('employee.company.profile');
});

Route::get('/company_units', function () {
	$units = DB::table('units')->where('id_company', Auth::user()->id_company)->get();

    return view('employee.company.units')->with('units', $units);
});

Route::get('/add_unit', function () {
    return view('employee.company.add_unit');
});

##############################################
###### 		Work with tickets 		##########
##############################################
Route::get('/create_ticket', function () {
	
	$units = DB::table('units')->where('id_company', Auth::user()->id_company)->get();
	
	$employees = DB::table('employees')
					->where('id_company', Auth::user()->id_company)
					->where('id_unit', Auth::user()->unit)
					->get();

	$priorities = DB::table('priorities')->get();

	return view('employee.tickets.create_ticket')
				->with('units', $units)
				->with('employees', $employees)
				->with('priorities', $priorities);
});

# View all incoming tickets
Route::get('/view_all_incoming_tickets', function (){
	
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
	$i=0;
	foreach($tickets as $ticket) {
		$current_executor_name = DB::table('employees')
			->where('id', $ticket->id_executor)
			->select('name')
			->get();

		#this loop gets exatcly the name string from object
		# which was recieved above
		$tmpName = "Нет исполнителя";
		foreach ($current_executor_name as $tmp) {
			$tmpName = $tmp->name;
		}
		
		$tickets[$i]->current_executor_name = $tmpName;
		$i++;
	} 
	
	
	   
	
		
	
	
	return view('employee.tickets.view_all_incoming_tickets')
			->with('tickets', $tickets)
			->with('employees', $employees)
			->with('current_executor', $current_executor);
});

# Appoint executor for ticket
Route::post('/employee/appoint_executor', 'EmployeeManagement\CRUDController@appoint_executor_to_ticket');

# View outgoing tickets
Route::get('/outgoing_tickets', function () {
	return view('employee.tickets.outgoing_tickets');
});

Route::get('/ticket_more_info', function () {

});



Route::post('/create_ticket', 'EmployeeManagement\CRUDController@create_ticket');
###### Work with tickets ends here ##########

#Route::post('/add_new_employee', 'EmployeeManagement\CRUDController@add_new_employee');

Route::post('/add_new_employee', 'EmployeeManagement\CRUDController@add_new_employee');

Route::post('/add_new_unit', 'EmployeeManagement\CRUDController@add_new_unit');
