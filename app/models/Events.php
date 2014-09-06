<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Events extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function tags()
	{
		return $this->belongsToMany('Tags', 'events-tags-relation');
	}
	public static function thirtyDays()
	{
		$events = Events::with('Tags')->orderBy('start_time', 'ASC')->whereBetween('start_time', array( date('Y-m-d', strtotime('now')), date('Y-m-d', strtotime('+30 days'))) )->get();
		return $events;
	}
}
