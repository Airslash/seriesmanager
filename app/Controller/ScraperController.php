<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Inserts series and episodes to database
 * @version        1.2.7
 * @last_modified  20:24 31/01/2016
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
		$defaultManager = new \Manager\DefaultManager();
		$imdbScraper    = new \Scraper\ImdbScraper();

		echo "<pre>";
		for ($i=1; $i<=$pages; $i+=50) {
			// Gets 50 series id from imdb from result page
			$seriesId = scrapeSeriesId("http://www.imdb.com/search/title?start=$i&title_type=tv_series");
			// Inserts serie into database
			foreach ($seriesId as $serieId) {
				echo "Scraping : $serieId";
				$this->insertSerie($serieId);
				// $serie = $defaultManager->superFind($serieId, "imdb_id", "series");
				// if ($serie) {
				// 	echo "Inserted : " . $serie["title"] . " - " . $episode["title"] . "\n";
				// }
			}
		}
		echo "</pre>";
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