<?php

class EventsUsers extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events-users';

	public static function attending($user_id)
	{
		$attending = EventsUsers::where('users_id', '=', $user_id)
								->join('events', 'events.id', '=', 'events-users.events_id')
								->where('events.start_time', '>', \Carbon\Carbon::now())
								->get();
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
		$attending = EventsUsers::attending(Auth::user()->id);
		$attends = array();
		if (empty($attending)) {
			return $attends;
        }
        foreach ($attending as $attend) {
            $attends[] = $attend['events_id'];
        }
        return $attends;
	}

}
