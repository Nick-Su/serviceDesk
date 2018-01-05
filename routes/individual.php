<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('individual')->user();

    //dd($users);

    return view('individual.home');
})->name('home');



Route::get('/create_ticket', 'IndividualManagement\CRUDController@showAvailableCompaniesForm');

Route::get('/outgoing_tickets', 'IndividualManagement\CRUDController@showOutgoingTickets');

Route::get('/create_ticket_form/{id_company}', 'IndividualManagement\CRUDController@showCreateTicketForm');

Route::get('/my_profile', 'IndividualManagement\CRUDController@showProfileForm');

Route::post('/change_personal_info', 'IndividualManagement\CRUDController@saveProfileInfo');

Route::post('/create_ticket/{id_company}', 'IndividualManagement\CRUDController@createTicket');


# Mark ticket as incomplete
Route::get('/individual_ticket_is_not_complete/{ticket}', 'IndividualManagement\CRUDController@individualTicketIsNotComplete');

# Mark ticket as completed by initiator
Route::get('/confirm_individual_ticket_complete_by_initiator/{ticket}', 'IndividualManagement\CRUDController@individualTicketCompleteByInitiator');

# Detailed info about ticket
Route::get('/more_info_individual_ticket/{ticket}', 'IndividualManagement\CRUDController@moreInfoIndividualTicket');