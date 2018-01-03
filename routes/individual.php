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