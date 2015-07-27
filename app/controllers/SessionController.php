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
			return Redirect::to('/')->with('flash_message', 'You have been logged in!');
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

	public function socialLogin($provider)
	{

		/**
		* Obtain an access token.
		*/
		try
		{

			dd(Facebook::getLoginUrl());
			$token = Facebook::getTokenFromRedirect();

			if ( ! $token)
			{
				return Redirect::to('/login')->with('error', 'Unable to obtain access token.');
			}
		}
		catch (FacebookQueryBuilderException $e)
		{
			return Redirect::to('/')->with('error', $e->getPrevious()->getMessage());
		}

		if ( ! $token->isLongLived())
		{
			/**
			* Extend the access token.
			*/
			try
			{
				$token = $token->extend();
			}
			catch (FacebookQueryBuilderException $e)
			{
				return Redirect::to('/')->with('error', $e->getPrevious()->getMessage());
			}
		}

		Facebook::setAccessToken($token);

		/**
		* Get basic info on the user from Facebook.
		*/
		try
		{
			$facebook_user = Facebook::object('me')->fields('id','name')->get();
		}
		catch (FacebookQueryBuilderException $e)
		{
			return Redirect::to('/')->with('error', $e->getPrevious()->getMessage());
		}

		// Create the user if not exists or update existing
		$user = User::createOrUpdateFacebookObject($facebook_user);

		// Log the user into Laravel
		Facebook::auth()->login($user);

		return Redirect::to('/')->with('message', 'Successfully logged in with Facebook');
	}

	public function socialCallback($provider)
	{

	}

}
