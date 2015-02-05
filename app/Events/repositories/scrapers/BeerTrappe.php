<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Monashee\PhpSimpleHtmlDomParser\PhpSimpleHtmlDomParser;
use Events\repositories\ScraperInterface;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class BeerTrappe extends Scraper implements ScraperInterface
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
	public function scrape()
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
		return "The BeerTrappe site was scraped.";
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
				
				$item['description'] = $event->parent()->next_sibling()->children(2)->plaintext;
				// $item['vendor_event_code'] = $event->parent()->next_sibling()->children(0)->children(0)->title;
				
				$item['title'] = $this->checkUK($this->cleanup($event->find('.ai1ec-event-title', 0)->plaintext, ENT_COMPAT, 'utf-8'));
				$item['location'] = $this->location->address . '<br>' . $this->location->city . ' ' . $this->location->state . ', ' . $this->location->zip;
				$item['hosted_by'] = $this->location->name;
				$item['created_by'] = 'admin';
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
	 * Stick the events we scraped into the DB.
	 */
	public function addToDB()
	{
		
		// Check the vendor ID to see if the event already exists.
		
		

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
	 * Pulls the location data from the DB and sets it to a property on the class.
	 */
	public function setLocationData()
	{
		$location = Locations::where('id', '=', $this->location_id)->first();
		$this->location = $location;
	}
}
