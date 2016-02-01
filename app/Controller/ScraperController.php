<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Inserts series and episodes to database
 * @version        1.3
 * @last_modified  13:43 01/02/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class ScraperController extends Controller {

	/**
	 * scrapeMostPopularSeries
	 *
	 * Scrapes top 50 most popular series from imdb
	 *
	 */
	public function scrapeMostPopularSeries($pages) {

		// Initializes objects
		$defaultController = new \Controller\DefaultController();
		$imdbScraper       = new \Scraper\ImdbScraper();
		$defaultManager    = new \Manager\DefaultManager();

		for ($i=1; $i<=$pages; $i+=50) {
			// Gets 50 series id from imdb from result page
			$seriesId = $imdbScraper->scrapeSeriesId("http://www.imdb.com/search/title?start=$i&title_type=tv_series");
			// Inserts serie into database
			foreach ($seriesId as $serieId) {
				// echo "Scraping : $serieId";
				$this->insertSerie($serieId);
				$serie = $defaultManager->findWhere($serieId, "imdb_id", "series");
				if ($serie) {
					$defaultController->showPrint_r($serie);
					// echo "Inserted : " . $serie["title"] . " - " . $episode["title"] . "\n";
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

	/**
	 * insertSerie
	 *
	 * Main ScraperController method
	 * Scrapes TV serie from imdb and inserts serie details into database
	 *
	 * @param  string  $imdb_id  imdb reference id
	 */
	public function insertSerie($imdb_id) {

		// Initializes objects
		$imdbScraper    = new \Scraper\ImdbScraper();
		$defaultManager = new \Manager\DefaultManager();
		$serieManager   = new \Manager\SerieManager();
		$episodeManager = new \Manager\EpisodeManager();

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