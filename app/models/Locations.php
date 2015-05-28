<?php

class Locations extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'locations';

	public function events()
	{
		return $this->belongsToMany('Events');
	}

}
