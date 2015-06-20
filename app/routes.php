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
Route::post('events', 'EventController@attend');
Route::post('event/attend', array('as' => 'event.attend', 'uses' => 'EventController@attend'));
Route::get('events', [
	'as' => 'events',
	'uses' => 'EventController@index'
]);
Route::resource('users','UsersController');

// These are our filtered routes for login
Route::group(array('before' => 'auth'), function()
    {
        Route::resource('event', 'EventController', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
        Route::get('profile/edit', 'UsersController@edit');

    }
);
Route::get('event/{id}', 'EventController@show');
Route::get('events', 'EventController@index');

Route::get('/', 'EventController@index');
Route::get('myevents', 'EventController@viewMyEvents');
Route::get('privacy', 'PagesController@privacy');
Route::get('location/{location_id}', 'EventController@locationEvents');
// Route::get('/test', 'HomeController@test');
// Route::get('new', 'EmailController@signUps');
// Route::get('summary', 'EmailController@summary');
