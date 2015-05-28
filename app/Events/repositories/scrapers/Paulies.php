<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Goutte\Client;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class Paulies extends Scraper
{
	public $html;
	public $crawler;
	public $client;
	public $location_id = 9;
	public $events = [];
	public $url = 'http://pauliestoastedbarrel.com/upcoming-events/action~month/';
	protected $event_urls = [];
	protected $current_year = '';
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
		$this->setCurrentYear();
		$this->nextMonthUrl();
		$this->scrapeEvents();
		$this->loadUrl($this->nextMonthUrl);
		$this->scrapeEvents();

		$this->addToDb();
		return "The " . (new \ReflectionClass($this))->getShortName() . " site was scraped.";
	}

	protected function nextMonthUrl()
	{
		$this->nextMonthUrl = $this->crawler->filter('.ai1ec-next-month')->attr('href');
	}

	protected function scrapeEvents()
	{
		$this->crawler->filter('.ai1ec-popover')->each(function ($node) {
			$this->scraping($node);
		});
	}

	protected function setCurrentYear()
	{
		$this->current_year = $this->crawler->filter('.ai1ec-next-year')->text() - 1;
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
		$lexevent['description'] = $this->description($node);
		$lexevent['full_details'] = '';
		$lexevent['event_type'] = 2;
		$lexevent['created_by'] = 'admin';
		$lexevent['locations_id'] = $this->location_id;
		$lexevent['vendor_event_id'] = $this->vendorId($node);
		$this->events[] = $lexevent;
		// print_r($lexevent);
	}

	protected function vendorId($node)
	{
		$eventUrl = $node->filter('.ai1ec-load-event')->attr('href');
		$eventUrl = parse_url($eventUrl);
		parse_str($eventUrl['query']);
		return $instance_id;
	}

	protected function getTitle($node)
	{
		return trim( $node->filter('.ai1ec-popup-title > a')->text() );
	}

	protected function start_time($node)
	{
		$date = $node->filter('.ai1ec-event-time')->text();
		$date = explode('–', $date);
		$holder = explode('@', $date[0]);
		$date = $holder[0] . ', ' . $this->current_year;
		return date('Y-m-d H:i:s', strtotime($date . $holder[1]));
	}

	protected function end_time($time)
	{
		return date('Y-m-d H:i:s', strtotime('+3 hours', strtotime($time)));
	}

	protected function description($node)
	{
		return $node->filter('.ai1ec-popup-excerpt')->text();
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
