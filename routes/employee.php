<?php
Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('employee')->user();

    return view('employee.home');
})->name('home');



Route::get('/getRequest', 'EmployeeManagement\CRUDController@sendTicketUpdate');

####################################
# Company Administration section
###################################


Route::get('/create_employee', [
	'middleware' => 'isAdmin',
	function () {
		$units = DB::table('units')->where('id_company', Auth::user()->id_company)->get();

    	return view('employee.create')->with('units', $units);
}]);

# Route protection
Route::middleware(['isAdmin'])->group(function () {

	Route::get('/management', function () {
	    $users[] = Auth::user();
	    $users[] = Auth::guard()->user();
	    $users[] = Auth::guard('employee')->user();

	    return view('employee.manage');
	});

	Route::get('/about_company', 'EmployeeManagement\CRUDController@showAboutCompanyForm');

	Route::get('/company_units', function () {
		$units = DB::table('units')->where('id_company', Auth::user()->id_company)->get();

	    return view('employee.company.units')->with('units', $units);
	});

	Route::get('/add_unit', function () {
	    return view('employee.company.add_unit');
	});

	Route::post('/add_new_employee', 'EmployeeManagement\CRUDController@add_new_employee');

	Route::post('/add_new_unit', 'EmployeeManagement\CRUDController@add_new_unit');

	Route::post('/fill_company_info', 'EmployeeManagement\CRUDController@fillCompanyInfo');

	# employee edit and delete
	Route::post('/delete_employee', 'EmployeeManagement\CRUDController@deleteEmployee');

	Route::get('/edit_employee/{id}', 'EmployeeManagement\CRUDController@showEditEmployeeForm');

	Route::post('/save_edit_employee_changes', 'EmployeeManagement\CRUDController@saveEditEmployeeChanges');

});
# Route protection ends here


Route::get('/my_profile', 'EmployeeManagement\CRUDController@showMyProfile');


#
# Company administration section ends here
#


##############################################
###### 		Work with tickets 		##########
##############################################

Route::get('/create_ticket', 'EmployeeManagement\CRUDController@showCreateTicketForm');

# View all incoming tickets
Route::get('/view_all_incoming_tickets', 'EmployeeManagement\CRUDController@getAllIncomingTickets');

# View all outgoing tickets
Route::get('/outgoing_tickets', 'EmployeeManagement\CRUDController@getAllOutgoingTickets');

# Appoint executor to ticket
Route::get('/appoint_executor_to_ticket', 'EmployeeManagement\CRUDController@appointExecutorToTicket');


# Actions to ticket buttons

# Reject ticekt
Route::get('/reject_ticket/{ticket}', 'EmployeeManagement\CRUDController@rejectTicket');

# Detailed info about ticket
Route::get('/more_info_ticket/{ticket}', 'EmployeeManagement\CRUDController@moreInfoTicket');

# Reopen ticket
Route::get('/reopen_ticket/{ticket}', 'EmployeeManagement\CRUDController@reopenTicket');

# Mark ticket as executable
Route::get('/take_the_ticket/{ticket}', 'EmployeeManagement\CRUDController@takeTheTicket');

# Refuse the ticket
Route::get('/refuse_the_ticket/{ticekt}', 'EmployeeManagement\CRUDController@refuseTheTicket');

# Mark tickete as completed by executor
Route::get('/ticket_complete/{ticket}', 'EmployeeManagement\CRUDController@ticketComplete');

# Mark ticket as completed by initiator
Route::get('/confirm_ticket_complete_by_initiator/{ticket}', 'EmployeeManagement\CRUDController@ticketCompleteByInitiator');

# Mark ticket as incomplete
Route::get('/ticket_is_not_complete/{ticket}', 'EmployeeManagement\CRUDController@ticketIsNotComplete');

Route::get('/tickets_archieve', function(){
	return view('employee.tickets.view_archieved_tickets');
});

# create tickets
Route::post('/create_ticket', 'EmployeeManagement\CRUDController@create_ticket');


///////////////////////////////////////////////////////
# Indi tickets

# Show all incoming tickets
Route::get('/view_all_incoming_external_tickets', 'EmployeeManagement\CRUDController@showAllIncomingExternalTickets');

# appoint executor to ticket
Route::get('/appoint_executor_to_individual_ticket', 'EmployeeManagement\CRUDController@appointExecutorToIndividualTicket');

# Reject ticekt
Route::get('/reject_individual_ticket/{ticket}', 'EmployeeManagement\CRUDController@rejectIndividualTicket');

# Detailed info about ticket
Route::get('/more_info_individual_ticket/{ticket}', 'EmployeeManagement\CRUDController@moreInfoIndividualTicket');

# Reopen ticket
Route::get('/reopen_individual_ticket/{ticket}', 'EmployeeManagement\CRUDController@reopenIndividualTicket');

# Mark ticket as executable
Route::get('/take_the_individual_ticket/{ticket}', 'EmployeeManagement\CRUDController@takeTheIndividualTicket');

# Refuse the ticket
Route::get('/refuse_the_individual_ticket/{ticket}', 'EmployeeManagement\CRUDController@refuseTheIndividualTicket');

# Mark tickete as completed by executor
Route::get('/individual_ticket_complete/{ticket}', 'EmployeeManagement\CRUDController@individualTicketComplete');



////////////////////////////
# Legals ticket
Route::get('/test', 'DynamicUpdateController@testfunction');
Route::post('/test', 'DynamicUpdateController@testfunction');

# Show all incoming tickets
Route::get('/view_all_incoming_external_legal_tickets/{ticket}', 'EmployeeManagement\CRUDController@showAllIncomingExternalLegalTickets');


// Origin
# Show all incoming tickets via AJAX
Route::get('/view_all_incoming_external_legal_tickets', 'EmployeeManagement\CRUDController@showAllIncomingExternalLegalTickets');

# appoint executor to ticket
Route::get('/appoint_executor_to_legal_ticket', 'EmployeeManagement\CRUDController@appointExecutorToLegalTicket');

# appoint executor to ticket
Route::get('/appoint_executor_to_legal_ticket', 'EmployeeManagement\CRUDController@appointExecutorToLegalTicket');

# Reject ticekt
Route::get('/reject_legal_ticket/{ticket}', 'EmployeeManagement\CRUDController@rejectLegalTicket');

# Detailed info about ticket
Route::get('/more_info_legal_ticket/{ticket}', 'EmployeeManagement\CRUDController@moreInfoLegalTicket');

# Reopen ticket
Route::get('/reopen_legal_ticket/{ticket}', 'EmployeeManagement\CRUDController@reopenLegalTicket');

# Mark ticket as executable
Route::get('/take_the_legal_ticket/{ticket}', 'EmployeeManagement\CRUDController@takeTheLegalTicket');

# Refuse the ticket
Route::get('/refuse_the_legal_ticket/{ticket}', 'EmployeeManagement\CRUDController@refuseTheLegalTicket');

# Mark tickete as completed by executor
Route::get('/legal_ticket_complete/{ticket}', 'EmployeeManagement\CRUDController@legalTicketComplete');

#
# Tickets' routes ends here
#



#  Route Protection
Route::get('/permission_denied', function(){
  return view('employee.permission_denied');
});




