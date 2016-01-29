<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Inserts series and episodes to database
 * @version        1.2.3
 * @last_modified  13:49 29/01/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class ScraperController extends Controller {

	/**
	 * scraper
	 * 
	 * Main ScrapeController method
	 * 
	 */
	public function scraper() {

		// Initializes objects
		$imdbScraper    = new \Scraper\ImdbScraper();
		$serieManager   = new \Manager\SerieManager();
		$episodeManager = new \Manager\EpisodeManager();
		$defaultManager = new \Manager\DefaultManager();

		echo "<pre>";
		// Gets most 50 most popular series id
		$mostPopularSeries = $imdbScraper->getMostPopularSeriesId();

		foreach ($mostPopularSeries as $SerieId) {
			insertSerie($imdb_id);
		}
		echo "</pre>";
	}

	/**
	 * insertSerie
	 * 
	 * Main ScraperController method
	 * 
	 * @param  string  $imdb_id  imdb reference id
	 */
	public function insertSerie($imdb_id) {

		// Initializes objects
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
		$lastId = $lastInsertManager->lastId();

		// Includes serie episodes from each season to database
		foreach ($seasons as $seasonIndex => $season) {
			foreach ($season["episodes"] as $episodeIndex => $episode) {

				// Inserts serie_id into episode table for joining
				$episode["serie_id"] = $lastId;

				// Inserts season into episode table					
				$episode["season"] = $seasonIndex;

				// Inserts season into episode table					
				$episode["episode"] = $episodeIndex;
				$episodeManager->insert($episode);

				echo "Inserted : ".$serie["title"]." se".$episode["season"]."ep".$episode["episode"]." - ".$episode["title"]."\n";
			}
		}
	}
}