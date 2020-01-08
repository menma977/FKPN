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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect('login');
    } else {
        return redirect('home');
    }
    // return view('welcome');
});

Route::get('/home/{username}', 'HomeController@indexUser')->name('indexUser');

// Auth::routes();
Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware(['rule', 'auth']);
Route::get('/package/{id}', 'HomeController@package')->name('package')->middleware(['rule', 'auth']);

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/', 'UserController@index')->name('index')->middleware(['rule', 'auth']);
    Route::get('/create', 'UserController@create')->name('create')->middleware(['rule', 'auth']);
    Route::post('/store', 'UserController@store')->name('store')->middleware(['rule', 'auth']);
    Route::get('/show', 'UserController@show')->name('show')->middleware(['rule', 'auth']);
    Route::get('/edit/{id}', 'UserController@edit')->name('edit')->middleware(['rule', 'auth']);
    Route::post('/update/{id}', 'UserController@update')->name('update')->middleware(['rule', 'auth']);
    Route::get('/delete/{id}', 'UserController@destroy')->name('delete')->middleware(['rule', 'auth']);
});

Route::group(['prefix' => 'deposit', 'as' => 'deposit.'], function () {
    Route::get('/', 'DepositController@index')->name('index')->middleware(['rule', 'auth']);
    Route::get('/update/{id}', 'DepositController@update')->name('update')->middleware(['rule', 'auth']);
    Route::get('/delete/{id}', 'DepositController@destroy')->name('delete')->middleware(['rule', 'auth']);
});

Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
    Route::get('/', 'TicketController@index')->name('index')->middleware(['rule', 'auth']);
    Route::get('/create', 'TicketController@create')->name('create')->middleware(['rule', 'auth']);
    Route::post('/store', 'TicketController@store')->name('store')->middleware(['rule', 'auth']);
    Route::get('/edit/{ticketID}', 'TicketController@edit')->name('edit')->middleware(['rule', 'auth']);
    Route::post('/update/{id}', 'TicketController@update')->name('update')->middleware(['rule', 'auth']);
    Route::get('/delete/{id}', 'TicketController@destroy')->name('delete')->middleware(['rule', 'auth']);
});

Route::group(['prefix' => 'investment', 'as' => 'investment.'], function () {
    Route::get('/', 'InvestmentController@index')->name('index')->middleware(['rule', 'auth']);
});

Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
    Route::get('/', 'WithdrawController@index')->name('index')->middleware(['rule', 'auth']);
    Route::get('/update/{id}', 'WithdrawController@update')->name('update')->middleware(['rule', 'auth']);
    Route::get('/delete/{id}', 'WithdrawController@destroy')->name('delete')->middleware(['rule', 'auth']);
});

Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
    Route::get('/invest', 'WithdrawController@index')->name('index');
});
