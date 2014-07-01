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

Route::model('event','Event');
Route::model('user','User');
Route::model('role','Role');

Route::model('user','[0-9]+');
Route::model('event','[0-9]+');
Route::model('role','[0-9]+');
Route::model('token','[0-9a-z]+');



/*
	----------------------------------------------------------------------
	Admin Routes
	----------------------------------------------------------------------
 */

 # User Management
    // Route::get('users/{user}/show', 'AdminUsersController@getShow');
    // Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    // Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    // Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    // Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    // Route::controller('users', 'AdminUsersController');



/*
	----------------------------------------------------------------------
	Frontend Routes
	----------------------------------------------------------------------
 */

// Route::controller('user','UserController');
// Route::get('/{event}','EventController@getEvent');


Route::get('/', function()
{
	return View::make('events/test');
});
Route::get('/lane', function()
{
	return View::make('lane');
});