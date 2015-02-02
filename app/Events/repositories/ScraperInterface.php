<?php namespace Events\repositories;

interface ScraperInterface {
	public function scrape();
	public function scraping();
	public function addToDb();
}