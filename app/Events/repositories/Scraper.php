<?php namespace Events\repositories;

use Monashee\PhpSimpleHtmlDomParser\PhpSimpleHtmlDomParser;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;
/**
* Base Scraper Class
*/
class Scraper
{
	
	/**
	 * fires the fire method on the class passed to events:scrape command
	 * @return string        A message saying the site was scraped.
	 */
	public function scrape($class)
	{
		$class = 'Events\repositories\scrapers\\' . $class;
		$parser = new PhpSimpleHtmlDomParser;
		$scraper = new $class($parser);
		return $scraper->fire();
	}
	
	/**
	 * Stick the events we scraped into the DB.
	 */
	public function addToDB()
	{
		// TODO: Check the vendor ID to see if the event already exists.
		// Save to DB
		foreach($this->events as $eventNew)
		{
			if (!empty($eventNew['title'])) {
				$entered = Events::create([
					'title' => $eventNew['title'],
					'description' => $eventNew['description'],
					'vendor_event_id' => $eventNew['vendor_event_id'],
					'hosted_by' => $eventNew['hosted_by'],
					'event_type' => $eventNew['event_type'],
					'location' => $eventNew['location'],
					'created_by' => $eventNew['created_by'],
					'start_time' => $eventNew['date']['start_time'],
					'end_time' => $eventNew['date']['end_time']
				]);

				EventsTagsRelation::create([
					'events_id' => $entered->id,
					'tags_id' => $entered->event_type
				]);
			}
		}
	}

	/**
	 * simple cleanup function to trim and string tags
	 */
	function cleanup($words)
	{
		return trim(strip_tags($words));
	}
	/**
	 * formats the dates into an array
	 * @param  string $date
	 * @return array       can contain up to 4 keys
	 */
	function dates($date, $year)
	{
		$date = utf8_encode($date);
		$returnValue = [];
		// first explode...splits a string on - or â 
		if (isset($date)) {
			$temp = explode('â', $date);
			$start = explode('@', $this->cleanup($temp[0]));
			$start_time = $start[0] . ' ' .$start[1] . ' ' . $year;
					
		}
		$start_time = date('Y-m-d H:i:s', strtotime($start_time));
			
		if (isset($temp[1])) {
			$end_time = $start[0] . ' ' . $temp[1] . ' ' . $year;
			$end_time = date('Y-m-d H:i:s', strtotime($end_time));
		} else {
			$end_time = $start_time;
		}
		
		return $returnValue = [
			'start_time' => $start_time,
			'end_time' => $end_time
		];
	}

	/**
	 * Basically cleans out in weird characters, but allows : - 
	 * @return string         cleaned up version of the string passed to it
	 */
	function clean($string) {
	   return preg_replace('/[^A-Za-z0-9\ :-]/', '', $string); // Removes special chars.
	}

	/**
	 * Checks to see if the Title of the event contains UK...if so, empties the title so we can skip putting it in the DB easily
	 */
	function checkUK($title)
	{
		$title = $this->clean($title);
		$title = str_replace('8217', "'", $title);
		$title = str_replace('038', "-", $title);
		if (preg_match('/^UK/', $title)) {
			return '';
		}
		if (preg_match('/^Mission Monday/', $title)) {
			return '';
		}
		if (preg_match('/^11/', $title)) {
			return '';
		}
		if (preg_match('/^Walking Dead/', $title)) {
			return '';
		}
		return $title;
	}
}