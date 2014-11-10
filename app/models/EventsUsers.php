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
	public function save()
	{
		parent::save();
	}
	
}
