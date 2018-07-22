<?php

use Illuminate\Http\Request;

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

Route::post('register', 'AuthController@postRegister');
Route::post('login', 'AuthController@postLogin');
Route::post('code', 'AuthController@postCode');

Route::post('show', 'ShowController@postShow');

Route::group(['middleware' => ['api', 'access_token']], function () {
    Route::put('phone', 'AuthController@putPhoneNumber');
});
