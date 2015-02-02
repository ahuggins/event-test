<?php namespace Events\repositories;

/**
* Base Scraper Class
*/
class Scraper
{
	
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