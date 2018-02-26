<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test', function(){
  return view('test');
});

Route::get('/auth', function(){
return view('legal.layout.auth');
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'individual'], function () {
  
  Route::get('/login', 'IndividualAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'IndividualAuth\LoginController@login');
  Route::post('/logout', 'IndividualAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'IndividualAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'IndividualAuth\RegisterController@register');

  Route::post('/password/email', 'IndividualAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'IndividualAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'IndividualAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'IndividualAuth\ResetPasswordController@showResetForm');

  Route::get('/register', function () {
    return view('individual.auth.register');
  });

  Route::get('/login', function () {
    return view('individual.auth.login');
  });

});

Route::group(['prefix' => 'legal'], function () {
  Route::get('/login', 'LegalAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'LegalAuth\LoginController@login');
  Route::post('/logout', 'LegalAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'LegalAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'LegalAuth\RegisterController@register');

  Route::post('/password/email', 'LegalAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'LegalAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'LegalAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'LegalAuth\ResetPasswordController@showResetForm');
});

#
############### Employee Routes #################
#
Route::group(['prefix' => 'employee'], function () {
  Route::get('/login', 'EmployeeAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'EmployeeAuth\LoginController@login');
  Route::post('/logout', 'EmployeeAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'EmployeeAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'EmployeeAuth\RegisterController@register');

  Route::post('/password/email', 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'EmployeeAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'EmployeeAuth\ResetPasswordController@showResetForm');

});



# Redirect from main page to the page, where user can choose login type
Route::get('/login', function() {
  return view('login');
});

Route::get('/register', function() {
  return view('register');
});
