<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Events\repositories\Scraper;

class ScrapeCommand extends ScheduledCommand {

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
	public function __construct(Scraper $scraper)
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
		$class = $this->argument('class');
		$message = $this->scraper->scrape($class);
		$this->info($message);
	}

	/**
	* When a command should run
	*
	* @param Scheduler $scheduler
	* @return \Indatus\Dispatcher\Scheduling\Schedulable
	*/
	public function schedule(Schedulable $scheduler)
	{
		return [
					// equivalent to: php /path/to/artisan command:name /path/to/file
					$scheduler->args(['BlueStallion'])
							->daily()
							->hours(13)
							->minutes(1),
					// equivalent to: php /path/to/artisan command:name /path/to/file --force --toDelete="expired" --exclude="admins" --exclude="developers"
					$scheduler->args(['BeerTrappe'])
							->daily()
							->hours(13)
							->minutes(5),
					$scheduler->args(['CosmicCharlies'])
							->daily()
							->hours(13)
							->minutes(10),
					$scheduler->args(['AlsBar'])
							->daily()
							->hours(13)
							->minutes(15),
					$scheduler->args(['NatashasBistro'])
							->daily()
							->hours(13)
							->minutes(20)
			];

		return $scheduler->daysOfTheWeek([Scheduler::THURSDAY])->hours(12)->minutes(30);
		// return $scheduler;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('class', InputArgument::REQUIRED, 'The name of the class you want to have scraped.'),
		);
	}

	public function environment()
	{
		return['production'];
	}

}
