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


Route::get('login', 'SessionController@create');
Route::get('logout', 'SessionController@destroy');
Route::resource('session', 'SessionController', ['only' => ['create', 'store', 'destroy']]);
Route::resource('users','UsersController');


Route::get('profile/edit', function()
{
	$user = User::find(Auth::user()->id);
	return View::make('users.profile.edit')->with(compact('user'));
})->before('auth');

Route::get('events', array('as' => 'events', function()
{
	// $events = Events::with('Tags')->where( DB::raw('DAY(start_time)'), '=', date('j'))->get();
	$events = Events::with('Tags')->orderBy('start_time', 'ASC')->whereBetween('start_time', array( date('Y-m-d', strtotime('now')), date('Y-m-d', strtotime('+30 days'))) )->get();
	$tags = Tags::all();
	return View::make('events/all', ['events' => $events, 'tags' => $tags]);
}));

Route::get('event.create', array('as' => 'event.create', 'uses' => 'EventAdminController@create') )->before('auth');
Route::resource('eventAdmin', 'EventAdminController');
Route::get('event.{id}', function($id)
{
	$event = Events::find($id);
	return View::make('events.event', ['event' => $event]);
});
Route::get('/', function()
{
	return View::make('events.soon');
});