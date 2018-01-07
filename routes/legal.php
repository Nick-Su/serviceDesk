<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('legal')->user();

    //dd($users);

    return view('legal.home');
})->name('home');

# Shows the profile page
Route::get('/profile', 'LegalManagement\CRUDController@showProfilePage');

# Save profile changes
Route::post('/change_profile_info', 'LegalManagement\CRUDController@saveProfileInfo');



# Show the create ticket form
Route::get('/create_ticket', 'LegalManagement\CRUDController@showAvailableCompaniesForm');

# Show the create ticket form
Route::get('/create_ticket_form/{id_company}', 'LegalManagement\CRUDController@showCreateTicketForm');

# Creates ticket and fill info to DB
Route::post('/create_ticket/{id_company}', 'LegalManagement\CRUDController@createTicket');


# show the outgoint tickets page
Route::get('/outgoing_tickets', 'LegalManagement\CRUDController@showOutgoingTickets');

# Mark ticket as incomplete
Route::get('/legal_ticket_is_not_complete/{ticket}', 'LegalManagement\CRUDController@legalTicketIsNotComplete');

# Mark ticket as completed by initiator
Route::get('/confirm_legal_ticket_complete_by_initiator/{ticket}', 'LegalManagement\CRUDController@legalTicketCompleteByInitiator');

# Detailed info about ticket
Route::get('/more_info_legal_ticket/{ticket}', 'LegalManagement\CRUDController@moreInfoLegalTicket');