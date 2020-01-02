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
Route::post('register', 'Api\UserController@register');

Route::group(['prefix' => 'cron', 'as' => 'cron.'], function () {
    Route::get('run', 'Api\CronJobController@run')->name('run');
});

Route::middleware('auth:api')->group(function () {
    Route::get('verification', 'Api\UserController@verification');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('show', 'Api\UserController@show')->name('show');
        Route::get('balance', 'Api\UserController@balance')->name('balance');
    });

    Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
        Route::post('store', 'Api\WithdrawController@store')->name('store');
    });

    Route::group(['prefix' => 'binary', 'as' => 'binary.'], function () {
        Route::get('', 'Api\BinaryController@index')->name('index');
    });

    Route::group(['prefix' => 'invest', 'as' => 'invest.'], function () {
        Route::get('', 'Api\InvestmentController@index')->name('index');
    });
});
