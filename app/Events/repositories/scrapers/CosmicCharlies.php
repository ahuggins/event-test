<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Monashee\PhpSimpleHtmlDomParser\PhpSimpleHtmlDomParser;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class CosmicCharlies extends Scraper
{
	public $html;
	public $location_id = 3;
	public $events = [];
	public $firstUrl = 'http://www.cosmic-charlies.com/calendar/';
	public $base_url = 'http://www.cosmic-charlies.com';
	// public $nextMonthURL = '';
	protected $parser;
	public $location;
	public $tagsAvailable;
	protected $event_urls = [];

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
		// $this->nextMonthURL = html_entity_decode($this->html->find('.ai1ec-next-month', 0)->href);
		$this->scraping();
		// $this->html = file_get_html($this->nextMonthURL);
		// $this->scraping();
		$this->addToDb();
		return "CosmicCharlies was scraped.";
	}

	/**
	 * This is the actual scraping magic. Sets the results in the Events property on the class.
	 */
	public function scraping()
	{
		$this->getEventUrls();
		$this->scrapeEvents();
		// Loop through the event urls and scrape data.

	}

	protected function scrapeEvents()
	{
		foreach ($this->event_urls as $url) {
			$url = $this->base_url . $url;
			$this->html = $this->parser->file_get_html($url);
			$this->scrapeEvent();
		}
	}

	protected function scrapeEvent()
	{
		$lexevent = [];
		foreach ($this->html->find('.event-info') as $event) {
			$lexevent['date']['start_time'] = $this->getDate($event);
			$lexevent['date']['end_time'] = $this->endTime($lexevent['date']['start_time']);
			$lexevent['title'] = $this->getHeadliner($event);
			$lexevent['location'] = $this->location->address . '<br>' . $this->location->city . ' ' . $this->location->state . ', ' . $this->location->zip;
			$lexevent['hosted_by'] = $this->location->name;
			$lexevent['created_by'] = 'admin';
			$lexevent['vendor_event_id'] = $this->getVendorId();
			$lexevent['description'] = $this->getDescription($lexevent);
			$lexevent['full_details'] = $this->getFullDetails();
			$lexevent['event_type'] = 2;
			$this->events[] = $lexevent;
		}
	}

	protected function endTime($start)
	{
		$end = strtotime('+4 hours', strtotime($start));
		return date('Y-m-d H:i:s', $end);
	}

	protected function getVendorId()
	{
		foreach ($this->html->find('.tickets') as $detail) {
			$vendor_id = str_replace('https://www.ticketfly.com/purchase/event/', '', $detail->href);
		}
		return $vendor_id;
	}

	protected function getDescription($lexevent)
	{
		foreach ($this->html->find('.price-range') as $price) {
			$event_price = $price->plaintext;
		}
		if ($event_price == '$0.00') {
			$event_price = 'FREE';
		}

		$presents = '';
		if ($this->html->find('.topline-info')) {
			foreach ($this->html->find('.topline-info') as $sponsor) {
				$presents = $sponsor->plaintext;
			}
		}


		$opening_acts = $this->getOpeningActs();

		return $presents . ' ' . $lexevent['title'] . $opening_acts  . '<br>' . $event_price;
	}

	protected function getOpeningActs()
	{
		$i = 1;
		if ($this->html->find('.supports')) {
			foreach ($this->html->find('.supports') as $supporting) {
				if ($i == 1) {
					$opening_acts = ' with opening act(s) ' . $supporting->plaintext;
				} else {
					$opening_acts .= ' + ' . $supporting->plaintext;
				}
				$i++;
			}
		} else {
			$opening_acts = '';
		}

		return $opening_acts;
	}

	protected function getFullDetails()
	{
		$desc = '';
		foreach ($this->html->find('.artist-boxes') as $description) {
			$desc .= $description->plaintext;
		}
		return $desc;
	}

	protected function getDate($event)
	{
		foreach ($event->find('.value-title') as $date) {
			$date = $date->title;
		}
		return $this->formatDate($date);
	}

	protected function formatDate($date)
	{
		$date = explode('T', $date);
		$date[1] = explode('-', $date[1]);
		$date = $date[0] . ' ' . $date[1][0];
		return date('Y-m-d H:i:s', strtotime($date));
	}

	protected function getHeadliner($event)
	{
		$i = 1;
		foreach ($event->find('.headliners') as $headliner) {
			if ($i == 1) {
				$lexevent['title'] = $headliner->plaintext;
			} else {
				$lexevent['title'] .= ' + ' . $headliner->plaintext;
			}
			$i++;
		}
		return $lexevent['title'];
	}

	protected function getEventUrls()
	{
		foreach($this->html->find('.one-event') as $event) {
			$this->event_urls[] = $event->find( '.headliners .url', 0 )->href;
		}
	}

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
