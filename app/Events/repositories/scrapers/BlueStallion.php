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
		return "The BlueStallion site was scraped";
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
				$item['raw_date'] = $event->parent()->next_sibling()->children(2)->plaintext;
				if ($event->find('.ai1ec-event-time', 0)) {
					$item['date'] = $this->dates(
						$this->cleanup(
							$item['raw_date']
							), $item['year']);
				}

				$item['vendor_event_id'] = $event->parent()->{'data-instance-id'};
				// $item['classes'] = $event->parent()->{'class'};
				// preg_match('@(ai1ec-event-id-)[1-9]*@', $item['classes'], $matches);
				// $id = preg_replace("/ai1ec-event-id-/", '', $matches[0]);
				// $event_id = preg_replace("/[^0-9]/", '', $id);
				// $item['vendor_event_id'] = $event_id;

				$item['description'] = $event->parent()->next_sibling()->children(4)->plaintext;
				$item['vendor_event_code'] = $event->parent()->next_sibling()->children(0)->children(0)->title;

				$item['title'] = $this->checkUK($this->cleanup($event->find('.ai1ec-event-title', 0)->plaintext, ENT_COMPAT, 'utf-8'));
				$item['location'] = $this->location->address . '<br>' . $this->location->city . ' ' . $this->location->state . ', ' . $this->location->zip;
				$item['hosted_by'] = $this->location->name;
				$item['created_by'] = 'admin';
				$item['event_type'] = $this->eventTags($item['vendor_event_code']);
				$this->events[] = $item;

			}
		}
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
}
