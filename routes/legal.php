<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('legal')->user();

    //dd($users);

    return view('legal.home');
})->name('home');

