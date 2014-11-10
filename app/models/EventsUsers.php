<?php

class EventsUsers extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	public $table = 'events-users';

	protected $fillable = ['users_id', 'events_id'];

	protected $incrementing = false;

	public function attending()
	{
		$attending = EventsUsers::where('users_id', '=', Auth::user()->id)->get();
		return $attending;
	}
	
}
