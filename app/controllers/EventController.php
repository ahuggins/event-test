<?php

class EventController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!Auth::check()) {
            return Redirect::to('/login');
        }
        $tags = Tags::all();
        $events = Events::thirtyDays();
        $attends = EventsUsers::getIds();
        return View::make('events/all', ['events' => $events, 'tags' => $tags, 'attending' => $attends]);
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
        $event = array();
        foreach ($tags as $tag) {
            $data[$tag['id']] = $tag['tag_text'];
        }
        return View::make('events.create', ['user' => $user, 'tags' => $data, 'event' => $event]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validation = Validator::make(Input::all(), ['title' => 'required', 'start_time' => 'required', 'end_time' => 'required', 'event_type' => 'required']);

        if ($validation->fails()){
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }
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
        $event = Events::find($id);
        return View::make('events.event', ['event' => $event]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user()->username;
        $tags = Tags::all();
        $event = Events::find($id);
        foreach ($tags as $tag) {
            $data[$tag['id']] = $tag['tag_text'];
        }
        $event['event_type'] = explode(',', $event->event_type);
        if ($user == $event->created_by) {
            return View::make('events.create', ['user' => $user, 'tags' => $data, 'event' => $event]);
        }
        return Redirect::to('/events')->withMessage('You can not edit that event.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $db_event = Events::findOrFail($id);

        // Remove all event tag relations
        $tags = EventsTagsRelation::where('events_id', '=', $id)->delete();

        // Add the updated event tag relations
        foreach(Input::get('event_type') as $tag ) {
            $insert = new EventsTagsRelation();
            $insert->events_id = $id;
            $insert->tags_id = $tag;
            $insert->save();
        }

        $image = $db_event->event_image;

        $db_event->fill(Input::all());
        if (Input::hasFile('event_image')) {
            $file = Input::file('event_image');
            $name = time() . '-' . $file->getClientOriginalName();
            $file = $file->move(public_path() . '/images/', $name);

            $db_event->event_image = $name;

        } else {
            $db_event->event_image = $image;
        }
        $db_event->event_type = implode(',', Input::get('event_type'));
        $db_event->save();
        return Redirect::to('/events');
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

    public function attend()
    {

        

        // return Input::all();
        if (Input::get('attending') == 'true') {
            EventsUsers::drop(Input::get('events_id'));        
        } else {
            EventsUsers::store(Input::get('events_id'));
        }
        
        
        // return 'This shit is working';
    }

}
