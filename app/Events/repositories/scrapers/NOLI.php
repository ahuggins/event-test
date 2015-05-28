<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Goutte\Client;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class NOLI extends Scraper
{
	public $html;
	public $crawler;
	public $client;
	public $location_id = 10;
	public $events = [];
	public $url = 'http://www.nolicdc.org/events/';
	protected $base_url = 'http://www.nolicdc.org';
	protected $event_urls = [];
	public $nextMonthURL = '';
	public $location;
	public $tagsAvailable;

	/**
	 * The steps involved in order to scrape the data...sets next month URL and scrapes both pages with scraping() method
	 */
	public function fire()
	{
		$this->setLocationData();
		$this->setTagsAvailable();
		$this->loadUrl($this->url);
		$this->scrapeEventUrls();
		$this->loopEventUrls();

		$this->addToDb();
		return "The " . (new \ReflectionClass($this))->getShortName() . " site was scraped.";
	}

	protected function loopEventUrls()
	{
		foreach ($this->event_urls as $url) {
			$this->loadUrl($this->base_url . $url);
			$this->scrapeEvents();
		}
	}

	protected function scrapeEventUrls()
	{
		$this->crawler->filter('.eventlist-title-link')->each(function ($node) {
			$this->event_urls[] = $node->attr('href');
		});
	}

	protected function scrapeEvents()
	{
		$this->crawler->filter('.eventitem')->each(function ($node) {
			$this->scraping($node);
		});
	}

	/**
	 * This is the actual scraping magic. Sets the results in the Events property on the class.
	 */
	public function scraping($node)
	{
		$lexevent = '';
		$lexevent['title'] = $this->getTitle($node);
		$lexevent['date']['start_time'] = $this->start_time($node);
		$lexevent['date']['end_time'] = $this->end_time($node);
		$lexevent['location'] = $this->location();
		$lexevent['hosted_by'] = $this->location->name;
		$lexevent['description'] = '';
		$lexevent['full_details'] = '';
		$lexevent['event_type'] = '2,4';
		$lexevent['locations_id'] = $this->location_id;
		$lexevent['created_by'] = 'admin';
		$lexevent['vendor_event_id'] = $this->vendorId($node);
		$this->events[] = $lexevent;
	}

	protected function vendorId($node)
	{
		$dataId = $node->attr('data-item-id');
		return $this->location_id . $dataId;
	}

	protected function getTitle($node)
	{
		return $node->filter('.eventitem-title')->text();
	}

	protected function start_time($node)
	{
		$date = $node->filter('.event-date')->attr('datetime');
		$time = $node->filteR('.event-time-12hr-start')->text();
		$date = date('Y-m-d H:i:s', strtotime($date . $time));
		return $date;
	}

	protected function end_time($node)
	{
		$date = $node->filter('.event-date')->attr('datetime');
		$time = $node->filteR('.event-time-12hr-end')->text();
		$date = date('Y-m-d H:i:s', strtotime($date . $time));
		return $date;
	}

	protected function location()
	{
		return $this->location->address . '<br>' . $this->location->city . ' ' . $this->location->state . ', ' . $this->location->zip;
	}

	protected function getEventUrls($url)
	{
		$this->crawler->filter('.shotitle')->each(function ($node) {
			print $node->text() . PHP_EOL;
		});
	}

	protected function loadUrl($url)
	{
		$this->client = new Client();
		$this->crawler = $this->client->request('GET', $url);
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
