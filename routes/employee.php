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
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('employee')->user();

    return view('employee.create');
});

Route::post('/add_new_employee', 'EmployeeManagement\CRUDController@add_new_employee');