<?php 

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Events\repositories\ScraperInterface;


class Scrape extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'events:scrape';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run the Scrapers for Lex.events';

	protected $scraper;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ScraperInterface $scraper)
	{
		parent::__construct();
		$this->scraper = $scraper;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->scraper->addToDb();
			// echo "<pre>";print_r($this->scraper->events);echo "</pre>";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
