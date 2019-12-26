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

// Auth::routes();
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware(['rule', 'auth']);

Route::group(['prefix' => 'user', 'as' => 'user.', 'admin', 'auth'], function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/create', 'UserController@create')->name('create');
    Route::post('/store', 'UserController@store')->name('store');
    Route::get('/show', 'UserController@show')->name('show');
    Route::get('/edit/{id}', 'UserController@edit')->name('edit');
    Route::post('/update/{id}', 'UserController@update')->name('update');
    Route::get('/delete/{id}', 'UserController@destroy')->name('delete');
});

Route::group(['prefix' => 'x', 'as' => 'x.'], function () {
    Route::get('/', 'xController@index')->name('index')->middleware(['admin', 'auth']);
    Route::get('/create', 'xController@create')->name('create')->middleware(['admin', 'auth']);
    Route::post('/store', 'xController@store')->name('store')->middleware(['admin', 'auth']);
    Route::get('/show', 'xController@show')->name('show')->middleware(['admin', 'auth']);
    Route::get('/edit/{id}', 'xController@edit')->name('edit')->middleware(['admin', 'auth']);
    Route::post('/update/{id}', 'xController@update')->name('update')->middleware(['admin', 'auth']);
    Route::get('/delete/{id}', 'xController@destroy')->name('delete')->middleware(['admin', 'auth']);
});
