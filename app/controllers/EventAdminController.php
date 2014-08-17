<?php 

class EventAdminController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Auth::user()->username;
		return View::make('events.create', ['user' => $user]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// return 'Store the event';
		$event = new Events();
		$event->title = Input::get('title');
		$event->start_time = date('Y-m-d H:i:s', strtotime(Input::get('start_time')));
		$event->end_time = date('Y-m-d H:i:s', strtotime(Input::get('end_time')));
		$event->location = Input::get('location');
		$event->description = Input::get('description');
		$event->created_by = Auth::user()->username;
		$event->save();
		return Redirect::to('/events');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
