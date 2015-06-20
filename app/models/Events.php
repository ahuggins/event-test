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
		$events = Events::with(['tags', 'locations'])
			->orderBy('start_time', 'ASC')
			->whereBetween('start_time', [\Carbon\Carbon::now()->subHours(8)->toDateString(), \Carbon\Carbon::now()->addDays(30)->toDateString()])
			->remember(60)
			->get();
		return $events;
	}

	public static function getTimeClass($start_time)
	{
		$class = '';
		if ( date('Ymd') == date('Ymd', strtotime($start_time) ) ) {
			$class[] = 'today';
		} elseif ( date('Ymd', strtotime('+1 day') ) == date('Ymd', strtotime($start_time) ) ) {
			$class[] = 'tomorrow';
		} elseif(
			date('Ymd', strtotime('next Thursday') ) == date('Ymd', strtotime($start_time) ) ||
			date('Ymd', strtotime('next Friday') ) == date('Ymd', strtotime($start_time) ) ||
			date('Ymd', strtotime('next Saturday') ) == date('Ymd', strtotime($start_time) ) ||
			date('Ymd', strtotime('next Sunday') ) == date('Ymd', strtotime($start_time) )
			) {
			$class[] = 'this-weekend';
		}
		if( ( date('W') == date('W', strtotime($start_time) ) ) )
		{
			$class[] = 'this-week';
		}
		elseif( ( date('W', strtotime('+1 week')) == date('W', strtotime($start_time) ) ) )
		{
			$class[] = 'next-week';
		}
		return $class;
	}

	public static function timeClasses($start_time)
	{
		$class = Events::getTimeClass($start_time);
		if (is_array($class)) {
			return implode(' ', $class);
		}
		return $class;
	}

	public function locations()
	{
		return $this->belongsTo('Locations');
	}

	public static function image($event)
	{
		if (empty($event->event_image)) {
			return $event->locations->event_image;
		}
		return $event->event_image;
	}

	public static function start($start_time)
	{
		return date('M d', strtotime( $start_time ) ) . ' @ ' . date( 'h:i A', strtotime( $start_time ) );
	}

	public static function getEndTimeAttribute($value)
	{
		return date( 'h:i A', strtotime( $value ) );
	}
}
