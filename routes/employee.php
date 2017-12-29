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

Route::get('/create_ticket', 'EmployeeManagement\CRUDController@showCreateTicketForm');

# View all incoming tickets
Route::get('/view_all_incoming_tickets', 'EmployeeManagement\CRUDController@getAllIncomingTickets');

# View all outgoing tickets
Route::get('/outgoing_tickets', 'EmployeeManagement\CRUDController@getAllOutgoingTickets');

# Appoint executor to ticket
Route::get('/appoint_executor_to_ticket', 'EmployeeManagement\CRUDController@appointExecutorToTicket');

#
# Actions to ticket buttons
#

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

Route::post('/create_ticket', 'EmployeeManagement\CRUDController@create_ticket');
#############################################
###### Work with tickets ends here ##########
#############################################


Route::post('/add_new_employee', 'EmployeeManagement\CRUDController@add_new_employee');

Route::post('/add_new_unit', 'EmployeeManagement\CRUDController@add_new_unit');
