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
Route::post('show/{show_id}/item/{item_id}', 'ShowController@postShowRecipeItem');
Route::post('show/{show_id}/start', 'ShowController@postShowStart');
Route::post('show/{show_id}/finish', 'ShowController@postShowFinished');
Route::post('show/{show_id}/step', 'ShowController@postShowStep');


Route::get('show/next', 'ShowController@getNextShow');
Route::get('show/{show_id}', 'ShowController@getShow');
Route::get('show/{show_id}/step', 'ShowController@getCurrentStep');

Route::put('show/{show_id}/step', 'ShowController@putNextStep');

Route::post('item', 'RecipeItemController@postRecipeItem');

Route::get('items', 'RecipeItemController@getRecipeItems');


Route::group(['middleware' => ['api', 'access_token']], function () {
    Route::put('phone', 'AuthController@putPhoneNumber');
});
