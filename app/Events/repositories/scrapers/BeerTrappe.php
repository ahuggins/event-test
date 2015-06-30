<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Monashee\PhpSimpleHtmlDomParser\PhpSimpleHtmlDomParser;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class BeerTrappe extends Scraper
{
	public $html;
	public $location_id = 2;
	public $events = [];
	public $firstUrl = 'http://www.thebeertrappe.com/calendar/action~month/';
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
		$this->addToDb();
		return "The " . (new \ReflectionClass($this))->getShortName() . " site was scraped.";
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
				$item['raw_date'] = $event->parent()->next_sibling()->children(1)->plaintext;

				$item['date'] = $this->dates(
					$this->cleanup( $item['raw_date'] ), $item['year']
				);

				$item['vendor_event_id'] = $event->parent()->{'data-instance-id'};

				$item['description'] = trim($event->parent()->next_sibling()->children(2)->plaintext);
				if (empty($item['description'])) {
					$item['description'] = trim($event->parent()->next_sibling()->children(3)->plaintext);
				}

				$item['vendor_event_code'] = $event->parent()->next_sibling()->children(0)->children(0)->title;

				$item['title'] = $this->cleanup($event->find('.ai1ec-event-title', 0)->plaintext, ENT_COMPAT, 'utf-8');
				$item['created_by'] = 'admin';
				$item['locations_id'] = $this->location_id;
				// $item['event_type'] = $this->eventTags($item['vendor_event_code']);
				$item['event_type'] = 1;
				$this->events[] = $item;
			}
		}
	}

	// public function eventTags($vendor_event_code)
	// {
	// 	$vendor_codes = [
	// 		'Test Batch Tuesday' => '1',
	// 		'Music' => '2',
	// 		'Food Trucks' => '3',
	// 		'Special Events' => '1',
	// 		'Group Meeting' => '7',
	// 		'Recurring Event' => '9',
	// 		'TV Event' => '5'
	// 	];
	// 	if (array_key_exists($vendor_event_code, $vendor_codes)) {
	// 		return $vendor_codes[$vendor_event_code];
	// 	}
	// 	return 11;
	// }

	/**
	 * Pulls the Tags Available in the DB and sets them to the property on this class as an array.
	 */
	public function setTagsAvailable()
	{
		$tags = Tags::all(['id', 'tag_text', 'filter_text']);
		foreach ($tags as $tag) {
			$this->tagsAvailable[] = $tag->toArray();
		}
	}



	/**
	 * Pulls the location data from the DB and sets it to a property on the class.
	 */
	public function setLocationData()
	{
		$location = Locations::where('id', '=', $this->location_id)->first();
		$this->location = $location;
	}
}
