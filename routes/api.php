<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

Route::post('login', 'Api\UserController@login');

Route::group(['prefix' => 'cron', 'as' => 'cron.'], function () {
    Route::get('run', 'Api\CronJobController@run')->name('run');
});

Route::middleware('auth:api')->group(function () {
    Route::post('register', 'Api\UserController@register');

    Route::get('verification', 'Api\UserController@verification');

    Route::get('logout', 'Api\UserController@logout');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('show', 'Api\UserController@show')->name('show');
        Route::get('balance', 'Api\UserController@balance')->name('balance');
        Route::post('update', 'Api\UserController@update')->name('update');
    });

    Route::group(['prefix' => 'deposit', 'as' => 'deposit.'], function () {
        Route::get('', 'Api\DepositController@index')->name('index');
        Route::post('create', 'Api\DepositController@create')->name('create');
        Route::get('show', 'Api\DepositController@show')->name('show');
    });

    Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
        Route::post('store', 'Api\WithdrawController@store')->name('store');
    });

    Route::group(['prefix' => 'binary', 'as' => 'binary.'], function () {
        Route::get('', 'Api\BinaryController@index')->name('index');
    });

    Route::group(['prefix' => 'vocer', 'as' => 'vocer.'], function () {
        Route::get('', 'Api\VocerPointController@index')->name('index');
    });

    Route::group(['prefix' => 'bonus', 'as' => 'bonus.'], function () {
        Route::get('', 'Api\BonusController@index')->name('index');
    });

    Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
        Route::get('', 'Api\TicketController@index')->name('index');
        Route::post('update', 'Api\TicketController@update')->name('update');
    });

    Route::group(['prefix' => 'invest', 'as' => 'invest.'], function () {
        Route::get('', 'Api\InvestmentController@index')->name('index');
        Route::get('/create/{id}', 'Api\InvestmentController@create')->name('create');
    });
});
