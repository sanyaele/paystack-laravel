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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/pay/{supplyId}', 'PayController@showPay')->name('show_pay');
Route::post('/pay', 'PayController@addPay')->name('add_pay');
// Route::get('/pay/otp/{transfer_code}', 'PayController@showOTP')->name('show_otp');
Route::post('/pay/otp', 'PayController@processOTP')->name('process_otp');
Route::get('/pay/verify/{reference}', 'PayController@verifyPay')->name('verify_pay');


Route::get('/ajax/getAccountName/{accountNumber}/{bankCode}', 'AjaxController@getAccount')->name('account_name');
Route::post('/ajax/addRecipient', 'AjaxController@addRecipient'); //  Real: AjaxController@addRecipient

