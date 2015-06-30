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
		// Save to DB
		foreach($this->events as $eventNew)
		{
			// if event exists...update it
			if ( $exists = Events::where( 'vendor_event_id', '=', $eventNew['vendor_event_id'] )
							->where('locations_id', '=', $eventNew['locations_id'])
							->first()
				)
			{
				// if $exists, then we know nothing has changed to the event. Need to look further
				print 'Exists: ' . $eventNew['title'] . PHP_EOL;
			} else {
				$begin = date('Y-m-d 00:00:00', strtotime($eventNew['date']['start_time']));
				$end = date('Y-m-d 23:59:59', strtotime($eventNew['date']['start_time']));
				if (Events::whereBetween('start_time', array($begin, $end))->where('title', '=', $eventNew['title'])->count() > 0 && !empty($eventNew['title'])) {
					$existingEvents = Events::whereBetween('start_time', array($begin, $end))
										->where('title', '=', $eventNew['title'])
										->where('locations_id', '=', $eventNew['locations_id'])
										->orderBy('start_time', 'ASC')
										->get();
					foreach ($existingEvents as $event) {
						if (date('m/d/y', strtotime($eventNew['date']['start_time'])) == date('m/d/y', strtotime($event['start_time']))) {
							$event['id'] = $event->id;
							$event['title'] = $eventNew['title'];
							$event['description'] = $eventNew['description'];
							$event['vendor_event_id'] = $eventNew['vendor_event_id'];
							$event['event_type'] = $eventNew['event_type'];
							$event['created_by'] = $eventNew['created_by'];
							$event['locations_id'] = $eventNew['locations_id'];
							$event['start_time'] = $eventNew['date']['start_time'];
							$event['end_time'] = $eventNew['date']['end_time'];
							$event->save();
							print 'Updated: ' . $eventNew['title'] . PHP_EOL;
						}
					}
				} else {
					if (!empty($eventNew['title'])) {
						$entered = Events::create([
							'title' => $eventNew['title'],
							'description' => $eventNew['description'],
							'vendor_event_id' => $eventNew['vendor_event_id'],
							'event_type' => $eventNew['event_type'],
							'locations_id' => $eventNew['locations_id'],
							'created_by' => $eventNew['created_by'],
							'start_time' => $eventNew['date']['start_time'],
							'end_time' => $eventNew['date']['end_time']
						]);

						$hold = explode(',', $entered['event_type']);
						foreach ($hold as $type) {
							EventsTagsRelation::create([
								'events_id' => $entered->id,
								'tags_id' => $type
							]);
						}

						print 'Added: ' . $entered['title'] . PHP_EOL;
					}
				}
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
			if (isset($start[1])) {
				$start_time = $start[0] . ' ' . $start[1] . ' ' . $year;
			} else {
				$day = str_replace(' all-day', '', $date);
				$start_time = $day . ' ' . $year . ' 12:00:00';
			}
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

}
