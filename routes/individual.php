<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('individual')->user();

    //dd($users);

    return view('individual.home');
})->name('home');



Route::get('/create_ticket', 'IndividualManagement\CRUDController@showAvailableCompaniesForm');