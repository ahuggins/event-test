<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/login', 'SessionController@create');
Route::get('/logout', 'SessionController@destroy');

Route::resource('session', 'SessionController', ['only' => ['create', 'store', 'destroy']]);
Route::resource('users','UsersController');


Route::get('admin', function()
{
	return 'Admin Page!';
})->before('auth');

Route::get('/events', function()
{
	$events = Events::all();
	return View::make('events/all', ['events' => $events]);
});
Route::get('/event/create', array('as' => 'event.create', 'uses' => 'EventAdminController@create') )->before('auth');
Route::resource('eventAdmin', 'EventAdminController');

Route::get('/', function()
{
	return View::make('events/test');
});