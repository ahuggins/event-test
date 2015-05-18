<?php namespace Events\repositories\scrapers;

use Events\repositories\Scraper;
use Goutte\Client;
use \Events;
use \Locations;
use \Tags;
use \EventsTagsRelation;

class NatashasBistro extends Scraper
{
	public $html;
	public $crawler;
	public $client;
	public $location_id = 5;
	public $events = [];
	public $url = 'http://www.beetnik.com/news/index.php?Page=';
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
		for ($i=1; $i <= 7; $i++) {
			$this->loadUrl($this->url . $i);
			$this->scrapeEvents();
		}
		$this->addToDb();
		return "The " . (new \ReflectionClass($this))->getShortName() . " site was scraped.";
	}

	protected function scrapeEvents()
	{
		$this->crawler->filter('.sho')->each(function ($node) {
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
		$lexevent['description'] = trim($node->filter('.moreinfo')->text());
		$lexevent['full_details'] = $this->fullDetails($node);
		$lexevent['event_type'] = $this->eventTags($lexevent['full_details']);
		$lexevent['created_by'] = 'admin';
		$lexevent['vendor_event_id'] = $this->vendorId($node);
		if (!preg_match('/Closed/', $lexevent['title'])) {
			$this->events[] = $lexevent;
		}
	}

	protected function vendorId($node)
	{
		$photo_path = $node->filter('.lefty > a')->attr('href');
		$path = pathinfo($photo_path);
		return $this->location_id . $path['filename'];
	}

	protected function getTitle($node)
	{
		$title = $node->filter('.shotitle')->text();
		$matches = '';
		preg_match('/[0-9][a|p][m]/', $title, $matches);
		$title = explode($matches[0], $title);
		return trim($title[1]);
	}

	protected function fullDetails($node)
	{
		return $node->filter('.righty')->text();
	}

	protected function start_time($node)
	{
		$title = $node->filter('.shotitle')->text();
		$matches = '';
		preg_match('/[0-9]*[a|p][m]/', $title, $matches);
		$title = explode($matches[0], $title);
		$title = str_replace(' @', '', $title);
		$date = date('Y-m-d', strtotime($title[0]));
		$time = date('H:i:s', strtotime($matches[0]));
		return $date . ' ' . $time;
	}

	protected function end_time($time)
	{
		return date('Y-m-d H:i:s', strtotime('+2 hours', strtotime($time)));
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

	public function eventTags($full_details)
	{
		if (preg_match('/[C|c]omedy/', $full_details) || preg_match('/[F|f]unny/', $full_details) || preg_match('/[J|j]oke/', $full_details)) {
			return 12;
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
