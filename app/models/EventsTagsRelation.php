<?php

class EventsTagsRelation extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events-tags-relation';

	public $timestamps = false;

	public $fillable = ['events_id', 'tags_id'];

}
