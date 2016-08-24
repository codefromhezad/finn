<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/dashboard', 'HomeController@dashboard');
Route::post('/add_entry', 'HomeController@add_entry');

Route::post('/ajax_toggle_check_entry', 'HomeController@ajax_toggle_check_entry');
Route::post('/ajax_delete_entry', 'HomeController@ajax_delete_entry');
Route::post('/ajax_edit_entry', 'HomeController@ajax_edit_entry');
