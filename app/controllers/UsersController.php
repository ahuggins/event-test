<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		return View::make('users.index', ['users' => $users]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{


		$validation = Validator::make(Input::all(), ['email' => 'required|email|unique:users', 'password' => 'required', 'username' => 'required|unique:users']);

		if ($validation->fails()){
			return Redirect::back()->withInput()->withErrors($validation->messages());
		}

		$user = new User();
		$user->email = Input::get('email');
		$user->username = Input::get('username');
		$user->password = Hash::make(Input::get('password'));
		$user->save();

		return Redirect::route('users.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($username)
	{
		$user = User::whereUsername($username)->first();
		return View::make('users.show', ['user' => $user]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit()
	{
		$user = User::find(Auth::user()->id);
		return View::make('users.profile.edit')->with(compact('user'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$user = User::find(Auth::user()->id);
		$user->email = Input::get('email');
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');

		$validation = Validator::make(Input::all(), ['email' => 'required|email|unique:users']);

		if ( $validation->fails() && ( Input::get( 'email' ) != Auth::user()->email ) ){
			return Redirect::back()->withInput()->withErrors($validation->messages());
		}
		
		$user->save();
		return Redirect::route('events');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}

