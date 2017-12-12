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
	
	if (Auth::user()->head_unit_id != NULL) {
		$tickets = DB::table('employee_tickets')
			->where('id_company', Auth::user()->id_company)
			->where('unit_to_id', Auth::user()->head_unit_id)
			->get();

		$employees = DB::table('employees')
			->where('id_company', Auth::user()->id_company)
			->get();

		} else {
			$tickets = DB::table('employee_tickets')
				->where('id_company', Auth::user()->id_company)
				->where('id_executor', Auth::user()->id)
				->get();
			$employees = NULL;
		}
	
	return view('employee.tickets.view_all_incoming_tickets')
			->with('tickets', $tickets)
			->with('employees', $employees);
});

# Appoint executor for ticket
Route::get('/appoint_executor', function () {

});

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
