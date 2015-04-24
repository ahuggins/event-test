<?php

use \ICal;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('events.soon');
	}

	public function test()
	{
		$event_url = 'http://bluestallionbrewing.com/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events';
		// $event_url = 'http://madbullshit.com/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events';
		$ical = new ical($event_url);

		// print '<pre>';
		// print_r($ical->events());
		// print '</pre>';
		// exit;

		$events = $ical->events();

		$i = 0;
		echo "<pre>";
		print_r($events);
		echo "</pre>";
		exit;
		foreach ($events as $event) {
			print_r($event);
			// if ($event['-US_array'][0] !== 'Recurring Event' && $event['-US_array'][0] !== 'Holidays' && $event['-US_array'][0] !== 'Community') {
				print '<br />';
				print $i . ': <br />';

				print 'UID: ' . $event['UID'] . '<br />';

				$combined = explode('DTSTART;TZID=America/New_York:', $event['DESCRIPTION']);

				print 'DESCRIPTION: ' . strip_tags($combined[0]) . '<br />';
				if (isset($combined[1])) {
					print 'START TIME: ' . date('M d, Y @ h:i a', $ical->iCalDateToUnixTimestamp($combined[1])) . '<br />';
				}
				// print 'CATEGORY: ' . $event['-US_array'][0] . '<br />';
				print 'SUMMARY: ' . $event['SUMMARY'] . '<br />';
				print 'URL: ' . $event['URL'] . '<br />';
				// print 'DTSTAMP: ' . $event['DTSTAMP'] . '<br />';

				$i++;
			// }
		}

		// $ics = file_get_contents($event_url);
		// echo "<pre>";
		// print_r($ics);
		// echo "</pre>";
	}

}
