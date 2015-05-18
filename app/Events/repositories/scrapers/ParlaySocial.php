<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Goutte\Client;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class ParlaySocial extends Scraper
{
	public $html;
	public $crawler;
	public $client;
	public $location_id = 7;
	public $events = [];
	public $url = 'http://parlaysocial.com/';
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
		$this->scrapeEvents();

		$this->addToDb();
		return "The " . (new \ReflectionClass($this))->getShortName() . " site was scraped.";
	}

	protected function scrapeEvents()
	{
		$this->crawler->filter('.eventOuterDiv')->each(function ($node) {
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
		$lexevent['date']['end_time'] = $this->end_time($lexevent['date']['start_time']);
		$lexevent['location'] = $this->location();
		$lexevent['hosted_by'] = $this->location->name;
		$lexevent['description'] = '';
		$lexevent['full_details'] = '';
		$lexevent['event_type'] = $this->eventTags($lexevent['title']);
		$lexevent['created_by'] = 'admin';
		$lexevent['vendor_event_id'] = $this->vendorId($lexevent['date']['start_time']);
		$this->events[] = $lexevent;
	}

	protected function vendorId($start_time)
	{
		return $this->location_id . strtotime($start_time);
	}

	protected function getTitle($node)
	{
		return $node->filter('.eventContentDiv')->text();
	}

	protected function start_time($node)
	{
		$date = $node->filter('.eventDateDiv')->text();
		$date = explode('@', $date);
		$date[0] = trim($date[0]);
		$time = $date[1];
		$date = explode('-', $date[0]);
		$date = $date[2] . '-' . $date[0] . '-' . $date[1];
		$date = date('Y-m-d', strtotime($date));
		$time = date('H:i:s', strtotime($time));
		return $date . ' ' . $time;
	}

	protected function end_time($time)
	{
		return date('Y-m-d H:i:s', strtotime('+3 hours', strtotime($time)));
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

	public function eventTags($data)
	{
		if ( preg_match('/Tannic Tuesdays/', $data) ) {
			return 17;
		}
		return 2;
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
