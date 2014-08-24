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
		$tags = Tags::all();
		foreach ($tags as $tag) {
			$data[$tag['id']] = $tag['tag_text'];
		}
		return View::make('events.create', ['user' => $user, 'tags' => $data]);
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
		$event->full_details = Input::get('full_details');
		$event->hosted_by = Input::get('hosted_by');
		$event->created_by = Auth::user()->username;
		$event->event_type = implode(',', Input::get('event_type'));
		if (Input::get('is_private')) {
			$event->is_private = 1;
		}
		if (Input::hasFile('event_image')) {
			$file = Input::file('event_image');
			$name = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . '/images/', $name);
			$event->event_image = $name;
		}
		$event->save();

		

		$event_id = $event->id;
		foreach (Input::get('event_type') as $tag) {
			$insert = new EventsTagsRelation();
			$insert->events_id = $event_id;
			$insert->tags_id = $tag;
			$insert->save();			
		}
		return Redirect::to('/events');
		// return $event;
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
