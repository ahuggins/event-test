<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Monashee\PhpSimpleHtmlDomParser\PhpSimpleHtmlDomParser;
use Goutte\Client;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class AlsBar extends Scraper
{
	public $html;
	public $crawler;
	public $client;
	public $location_id = 4;
	public $events = [];
	public $url = 'http://www.alsbarlexington.com/calendar/?view=calendar&month=';
	public $current_month = '';
	public $next_month = '';
	protected $event_urls = [];
	public $nextMonthURL = '';
	protected $parser;
	public $location;
	public $tagsAvailable;

	function __construct(PhpSimpleHtmlDomParser $parser)
	{
		$this->parser = $parser;
		$this->current_month = date('F-Y');
		$this->next_month = date('F-Y', strtotime('+1 month'));
	}

	/**
	 * The steps involved in order to scrape the data...sets next month URL and scrapes both pages with scraping() method
	 */
	public function fire()
	{
		$this->getEventUrls($this->url . $this->current_month);
		$this->getEventUrls($this->url . $this->next_month);
		$this->setLocationData();
		$this->setTagsAvailable();
		$this->scrapeEvents();
		$this->addToDb();
		return "The " . (new \ReflectionClass($this))->getShortName() . " site was scraped.";
	}

	protected function scrapeEvents()
	{
		foreach ($this->event_urls as $url) {
			$this->crawler = $this->client->request('GET', $url);
			$this->scraping();
		}
	}

	/**
	 * This is the actual scraping magic. Sets the results in the Events property on the class.
	 */
	public function scraping()
	{
		$lexevent = '';
		$lexevent['title'] = $this->crawler->filter('.eventitem-title')->text();
		$lexevent['date']['start_time'] = $this->start_time();
		$lexevent['date']['end_time'] = $this->end_time();
		$lexevent['location'] = $this->location();
		$lexevent['hosted_by'] = $this->location->name;
		$lexevent['event_type'] = $this->eventTags($lexevent['title']);
		$lexevent['description'] = '';
		$lexevent['full_details'] = '';
		$lexevent['created_by'] = 'admin';
		$lexevent['vendor_event_id'] = $this->crawler->filter('.eventitem')->attr('data-item-id');
		$this->events[] = $lexevent;
	}

	protected function start_time()
	{
		$raw_date = $this->crawler->filter('.event-date')->text();
		$start_time = $this->crawler->filter('.event-time-12hr-start')->text();
		$date = $raw_date . ' ' . $start_time;
		return date('Y-m-d H:i:s', strtotime($date));
	}

	protected function end_time()
	{
		$raw_date = $this->crawler->filter('.event-date')->text();
		$start_time = $this->crawler->filter('.event-time-12hr-end')->text();
		$date = $raw_date . ' ' . $start_time;
		return date('Y-m-d H:i:s', strtotime($date));
	}

	protected function location()
	{
		return $this->location->address . '<br>' . $this->location->city . ' ' . $this->location->state . ', ' . $this->location->zip;
	}

	protected function getEventUrls($url)
	{
		$this->client = new Client();
		$this->crawler = $this->client->request('GET', $url);
		$this->crawler->filter('h1 > a ')->each(function ($node) {
			if ($node->attr('href') != '/') {
				$this->event_urls[] = $node->attr('href');
			}
		});
	}

	public function eventTags($title)
	{
		if (preg_match('/Comedy/', $title) || preg_match('/Funny/', $title)) {
			return 12;
		}
		if (preg_match('/Poet/', $title) || preg_match('/Bianca/', $title)) {
			return 13;
		}
		if (preg_match('/Film/', $title)) {
			return 15;
		}
		if (preg_match('/Open Mic/', $title)) {
			return 14;
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
