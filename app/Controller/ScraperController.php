<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * ScraperController
 * 
 * Scrapes and inserts series and episodes to database
 * 
 * @version        1.3.3
 * @last_modified  00:04 02/02/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @method         scrapeMostPopularSeries  Scrapes top 50 most popular series from imdb
 * @method         scrapeSerie              Scrapes first TV serie from imdb result page, if any
 * @method         insertSerie              Main ScraperController method
 */
class ScraperController extends Controller {

	/**
	 * scrapeMostPopularSeries
	 *
	 * Scrapes most popular TV series from imdb result page
	 *
	 * @version                1.1
	 * @param  integer  $from  Start from page
	 * @param  integer  $to    ... To page
	 */
	public function scrapeMostPopularSeries($from, $to) {

		// Initializes objects
		$defaultController = new \Controller\DefaultController();
		$imdbScraper       = new \Scraper\ImdbScraper();
		$defaultManager    = new \Manager\DefaultManager();
		$from = $from*50;
		$to = $to*50;

		for ($i=$from; $i<=$to; $i+=50) {
			// Gets 50 series id from imdb from result page
			$seriesId = $imdbScraper->scrapeSeriesId("http://www.imdb.com/search/title?start=$i&title_type=tv_series");
			// Inserts serie into database
			foreach ($seriesId as $serieId) {
				$this->insertSerie($serieId);
				$serie = $defaultManager->findWhere($serieId, "imdb_id", "series");
				if ($serie) {
					$defaultController->showPrint_r($serie);
				}
			}
		}
	}

	/**
	 * scrapeSerie
	 * 
	 * Scrapes first TV serie from imdb result page, if any
	 * 
	 * @version          2.5.2
	 * @param   string   $title User query as serie title
	 * @return  string   Contains imdb_id
	 * @return  boolean  False when query returned no results
	 */
	public function scrapeSerie($title) {

		// Initializes scraper
		$imdbScraper    = new \Scraper\ImdbScraper();
		$defaultManager = new \Manager\DefaultManager();

		// Check if title is already into database
		$isPresent = $defaultManager->findWhere($title, "title", "series");

		if (!$isPresent) {

			// Gets series id containing $title
			$seriesId = $imdbScraper->scrapeSeriesId('http://www.imdb.com/search/title?title='.urlencode($title).'&title_type=tv_series');

			// Inserting serie into database when results are returned 
			if ($seriesId) {
				// Query success
				$this->insertSerie($seriesId[0]);
			} else {
				return false;
			}
		}
	}

	/**
	 * insertSerie
	 *
	 * Scrapes TV serie from imdb and inserts serie details into database
	 *
	 * @version                  2.5.2
	 * @param  string  $imdb_id  imdb reference id
	 */
	public function insertSerie($imdb_id) {

		// Initializes objects
		$imdbScraper    = new \Scraper\ImdbScraper();
		$defaultManager = new \Manager\DefaultManager();
		$serieManager   = new \Manager\SerieManager();
		$episodeManager = new \Manager\EpisodeManager();

		// Check if serie is already into database
		$isPresent = $defaultManager->findWhere($imdb_id, "imdb_id", "series");

		if (!$isPresent) {
			$serie = $imdbScraper->scrapeSerieById($imdb_id);

			// Joins genre table data into comma separated string
			$serie["genre"] = join(", ", $serie["genre"]);

			// Joins actors table data into comma separated string
			$serie["actors"] = join(", ", $serie["actors"]);

			// Sets season count into table
			$serie["season_count"] = count($serie["seasons"]);

			// Stores seasons table into new table
			$seasons = $serie["seasons"];

			// Deletes "seasons" table from $series
			unset($serie["seasons"]);

			// Includes serie to database
			$serieManager->insert($serie);
			$lastId = $defaultManager->lastId();

			// Includes serie episodes from each season to database
			foreach ($seasons as $seasonIndex => $season) {
				foreach ($season["episodes"] as $episodeIndex => $episode) {

					// Inserts series primary key into episodes for future table juncture
					$episode["serie_id"] = $lastId;

					// Inserts season number into episodes table
					$episode["season"] = $seasonIndex;

					// Inserts episode number into episodes table
					$episode["episode"] = $episodeIndex;
					$episodeManager->insert($episode);
				}
			}
		}
	}
}