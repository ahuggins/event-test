<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Monashee\PhpSimpleHtmlDomParser\PhpSimpleHtmlDomParser;
use Events\repositories\ScraperInterface;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class BlueStallion extends Scraper implements ScraperInterface
{
	public $html;
	public $location_id = 1;
	public $events = [];
	public $firstUrl = 'http://bluestallionbrewing.com/events/action~month/request_format~html/';
	// public $firstUrl = 'http://madbullshit.com/calendar/action~month/request_format~html/';
	public $nextMonthURL = '';
	protected $parser;
	public $location;
	public $tagsAvailable;

	function __construct(PhpSimpleHtmlDomParser $parser)
	{
		$this->parser = $parser;
	}

	/**
	 * The steps involved in order to scrape the data...sets next month URL and scrapes both pages with scraping() method
	 */
	public function fire()
	{
		$this->html = $this->parser->file_get_html($this->firstUrl);
		$this->setLocationData();
		$this->setTagsAvailable();
		// $this->scrape();
		$this->nextMonthURL = html_entity_decode($this->html->find('.ai1ec-next-month', 0)->href);
		$this->scraping();

		$this->html = file_get_html($this->nextMonthURL);
		$this->scraping();
		// print_r($this->events);
		$this->addToDb();
		return "The " . (new \ReflectionClass($this))->getShortName() . " site was scraped";
	}

	/**
	 * This is the actual scraping magic. Sets the results in the Events property on the class.
	 */
	public function scraping()
	{
		$item['year'] = $this->html->find('.ai1ec-next-year', 0)->plaintext - 1;
		// Find all article blocks
		foreach($this->html->find('.ai1ec-day') as $day) {
			foreach( $day->find('.ai1ec-event') as $event){
				$item['raw_date'] = trim($event->parent()->next_sibling()->children(2)->plaintext);

				// if ($event->find('.ai1ec-event-time', 0)) {
					$item['date'] = $this->dates(
						$this->cleanup(
							$item['raw_date']
							), $item['year']);
				// }
				// if ($this->checkUK($this->cleanup($event->find('.ai1ec-event-title', 0)->plaintext, ENT_COMPAT, 'utf-8')) == 'Beer Release: Maibock') {
					// print_r($item);
				// }

				$item['vendor_event_id'] = $event->parent()->{'data-instance-id'};

				$item['description'] = $event->parent()->next_sibling()->children(4)->plaintext;
				$item['vendor_event_code'] = $event->parent()->next_sibling()->children(0)->children(0)->title;
				$item['title'] = $this->checkUK($this->cleanup($event->find('.ai1ec-event-title', 0)->plaintext, ENT_COMPAT, 'utf-8'));
				$item['location'] = $this->location->address . '<br>' . $this->location->city . ' ' . $this->location->state . ', ' . $this->location->zip;
				$item['hosted_by'] = $this->location->name;
				$item['created_by'] = 'admin';
				$item['locations_id'] = $this->location_id;
				$item['event_type'] = $this->eventTags($item['vendor_event_code']);
				$this->events[] = $item;

			}
		}
		// print_r($this->events);
	}

	public function eventTags($vendor_event_code)
	{
		$vendor_codes = [
			'Test Batch Tuesday' => '1',
			'Music' => '2',
			'Food Trucks' => '3',
			'Special Events' => '1',
			'Group Meeting' => '7',
			'Recurring Event' => '9',
			'TV Event' => '5',
			'Beer Tapping' => '1'
		];
		if (array_key_exists($vendor_event_code, $vendor_codes)) {
			return $vendor_codes[$vendor_event_code];
		}
		return 11;
	}

	/**
	 * Pulls the Tags Available in the DB and sets them to the property on this class as an array.
	 */
	public function setTagsAvailable()
	{
		if( $tags = Tags::all(['id', 'tag_text', 'filter_text']) ) {
			foreach ($tags as $tag) {
				$this->tagsAvailable[] = $tag->toArray();
			}
		} else {
			print "There are no tags in the db" . PHP_EOL;
			exit;
		}
	}

	/**
	 * Pulls the location data from the DB and sets it to a property on the class.
	 */
	public function setLocationData()
	{
		if( $location = Locations::where('id', '=', $this->location_id)->first() ) {
			$this->location = $location;
		} else {
			print "Location: " . $this->location_id . " does not exist in Database." . PHP_EOL;
			exit;
		}
	}

	/**
	 * Checks to see if the Title of the event contains UK...if so, empties the title so we can skip putting it in the DB easily
	 */
	private function checkUK($title)
	{
		$title = $this->clean($title);
		$title = str_replace('8217', "'", $title);
		$title = str_replace('8211', "-", $title);
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
