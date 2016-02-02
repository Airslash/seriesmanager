<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * ApiController
 *
 * Controls seriesmanager main api
 *
 * @version          3.2.1 beta
 * @last_modified    12:36 02/02/2016
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @method           seriesManager  Main seriesmanager API
 * @method           searchSerie       Searches for TV serie into database by keyword
 * @method           randomSerie       Sends random series from database in json format
 * @method           scrapeSerie       Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
 * @method           findSerie         Finds TV serie into database by id
 * @method           randomSerie       Sends random amount of series from database in json format
 * @todo                               namespace?
 */
class ApiController extends Controller {

	/**
	 * seriesManager
	 *
	 * Main seriesmanager API
	 * Searches for TV serie into database by title
	 * Scrapes TV serie details from imdb when not present into database
	 * Returns TV serie details in json format
	 *
	 * @version  1.1.2
	 * @api
	 * @assumes  string   $_GET['api_key']          API key (fake)
	 * @assumes  string   $_GET['method']           One of five methods availlable
	 * @assumes  string   $_GET['searchserie']      Searches for TV serie into database by keyword
	 * @assumes  string   $_GET['getserie']         Returns TV serie details in json format
	 * @assumes  string   $_GET['scrapeserie']      Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
	 * @assumes  string   $_GET['getrandomseries']  Sends random series from database in json format
	 * @assumes  integer  $_GET['limit']            TV serie count to send to client
	 * @assumes  integer  $_GET['id']               TV serie primary key
	 * @return   object                              TV serie details
	 * 
	 * @assumes  string   $_GET['getseasons']       Returns TV serie seasons in json format
	 */
	public function seriesManager() {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// Gets $method from $_GET
		$method = $_GET['method'];

		// Gets $apikey from $_GET
		$api_key = $_GET['api_key'];

		// API key validation
		if ($api_key == 'inwexrlzidlwncjfrrahtexduwskgtvk'){
			switch ($method) {
				case 'searchserie':
					// Gets $keyword from $_GET
					$keyword = $_GET['keyword'];
					$this->searchSerie($keyword);
					break;
				case 'getserie':
					// Gets $id from $_GET
					$id = $_GET['id'];
					$this->getSerie($id);
					break;
				// case 'getseasons':
				// 	// Gets $id from $_GET
				// 	$id = $_GET['id'];
				// 	$this->getSeasons($id);
				// 	break;
				case 'scrapeserie':
					// Gets $keyword from $_GET
					$keyword = $_GET['keyword'];
					$this->scrapeSerie($keyword);
					break;
				case 'getrandomseries':
					// Gets $limit from $_GET
					$limit = $_GET['limit'];
					$this->getRandomSeries($limit);
					break;
				default:
					return 'Invalid method';
			}
		} else {
			return 'You need a valid api key to perform this action.';
		}
	}

	/**
	 * searchSerie
	 *
	 * Searches for TV serie into database by keyword
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version  1.1
	 * @param    string  $keyword  TV serie title
	 * @return   object            TV series details
	 */
	public function searchSerie($keyword) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// Searches for TV serie into database by keyword
		$series = $defaultManager->findLike($keyword, "title", "series");

		// When TV serie not present into database
		if (!$series) {
			return false;
		} else {
			// Returns json to client
			$this->showJson($series);
		}

	}

	/**
	 * scrapeSerie
	 *
	 * Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
	 * Adds TV serie details into database when found on imdb
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version  1.1 beta
	 * @param    string  $title  TV serie title
	 * @return   object          TV serie details
	 * @todo                     Not found
	 */
	public function scrapeSerie($title) {
		$defaultController = new \Controller\DefaultController();
		$scraperController = new \Controller\ScraperController();
		$defaultManager    = new \Manager\DefaultManager();

		// Searches for TV serie into database by title
		$serie = $defaultManager->findLike($title, "title", "series");

		// When TV serie not present into database
		if (!$serie) {
			// Scrapes TV serie (by title)
			$scraperController->scrapeSerie($title);

			// Searches for TV serie into database by title
			$serie = $defaultManager->findLike($title, "title", "series");
			if (!$serie) {
				// Returns Not found message to client
				$this->$show("Not found");
			} else {
				// Returns json to client
				$this->showJson($serie);
			}
		} else {
			// Returns json to client
			$this->showJson($serie);
		}
	}

	/**
	 * getSerie
	 *
	 * Gets TV serie from database by id
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version  1.0 beta
	 * @param    string  $id  TV serie title
	 * @return   object       TV series details
	 * @todo                  Build full serie table
	 */
	public function getSerie($id) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// Gets TV serie from database by id
		$serie = $defaultManager->findWhere($id, "id", "series");

		// When TV serie not present into database
		if (!$serie) {
			return false;
		} else {

			debug($serie);
			die();

			// Gets every season episode
			$seasons = $this->getSeasons($id, $serie["season_count"]);

			// Inserts seasons into $serie array
			$serie["seasons"] = $seasons;

			// Returns json to client
			$this->showJson($serie);
		}
	}

	/**
	 * getSeasons
	 *
	 * gets TV serie season episodes from database by serie primary key and season
	 *
	 * @version     2.1
	 * @deprecated  2.1
	 * @param       integer  $id  TV serie primary key
	 * @return      object        TV serie details
	 */
	protected function getSeasons($id, $seasonCount) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();
		$episodeManager    = new \Manager\EpisodeManager();

		// Gets serie episodes by season
		for ($i=1; $i<=$seasonCount; $i++){

			// Gets TV serie seasons from database by id
			$seasons[$i]["episodes"] = $episodeManager->findEpisodes($id, $i);
		}
		
		// Returns array
		return $seasons;
	}

	/**
	 * getRandomSeries
	 *
	 * Sends random series from database in json format
	 *
	 * @version  1.3
	 * @param    integer  $limit  Series count to retrieve from database
	 * @return   object           TV serie details
	 */
	public function getRandomSeries($limit) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// Finds random serie into database
		$series = $defaultManager->getRandom($limit, "series");

		// Returns json to client
		$this->showJson($series);
	}
}