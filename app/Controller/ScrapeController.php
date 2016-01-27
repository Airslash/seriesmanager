<?php

namespace Controller;

use \W\Controller\Controller;

class ScrapeController extends Controller
{

	/**
	 * Scaping de base
	 */
	public function scrape()
	{
		$scraper = new \Scraper\ImdbScraper("Blabla");
		$result = $scraper->scrape();
		echo "<pre>";
		print_r($result);
		echo "</pre>";
	}
}