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

use App\Models\Show;

Route::get('/', function () {
    return Show::create([
        'start_time' => '2018-07-21 21:44:10',
        'title' => "OP",
        'description' => "Something",
        'run_time_in_minutes' => 30,
        'show_image_header' => "https"
    ]);
});
