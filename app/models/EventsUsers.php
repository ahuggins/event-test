<?php

class EventsUsers extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events-users';

	public static function attending()
	{
		$attending = EventsUsers::where('users_id', '=', Auth::user()->id)->get();
		return $attending;
	}

	public static function store($event_id)
	{	
		$attendee = new EventsUsers();
        $attendee->events_id = $event_id;
        $attendee->users_id = Auth::user()->id;
        $attendee->save();
	}

	public static function drop($event_id)
	{
		$attendee = new EventsUsers();
		$attendee->where('events_id', '=', $event_id)->where('users_id', '=', Auth::user()->id)->delete();
	}


	public static function getIds()
	{
		$attending = EventsUsers::attending();
		$attends = array();
		if (!empty($attending)) {
			return $attends;
        }
        foreach ($attending as $attend) {
            $attends[] = $attend['events_id'];
        }
        return $attends;
	}

}
