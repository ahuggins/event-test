<?php

class SessionController extends \BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if ( Auth::check() ) return Redirect::to('/');
		return View::make('session.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$input = Input::all();
        $attempt = Auth::attempt([
			'email' => $input['email'],
			'password' => $input['password'],
		]);
        if($attempt) {
            return Redirect::action('UsersController@show', Auth::id())->with('flash_message', 'You have been logged in!');
        }
        return Redirect::to('/session/create')->with('flash_message', '<span class="bg-danger">There was an error with the info you provided!</span>');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::route('session.create');
	}


}
