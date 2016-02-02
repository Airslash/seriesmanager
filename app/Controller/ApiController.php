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
	 * @version  1.1.1
	 * @api
	 * @assumes  string  $_POST['method']   One of three methods availlable
	 * @assumes  string  $_POST['api_key']  API key (fake)
	 * @assumes  string  $_POST['search']   Searches for TV serie into database by keyword
	 * @assumes  string  $_POST['scrape']   Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
	 * @assumes  string  $_POST['random']   Sends random series from database in json format
	 * @assumes  string  $_POST['limit']    TV serie count to send to client
	 * @return   object                     TV serie details
	 */
	public function seriesManager() {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// Gets $method from $_POST
		$method = $_POST['method'];

		// Gets $apikey from $_POST
		$apikey = $_POST['api_key'];

		// API key validation
		if ($api_key = 'inwexrlzidlwncjfrrahtexduwskgtvk'){
			switch ($method) {
				case 'searchserie':
					// Gets $keyword from $_POST
					$keyword = $_POST['keyword'];
					$this->searchSerie($keyword);
					break;
				case 'getserie':
					// Gets $id from $_POST
					$keyword = $_POST['id'];
					$this->getSerie($id);
					break;
				case 'getseasons':
					// Gets $id from $_POST
					$id = $_POST['id'];
					$this->getSeasons($id);
					break;
				case 'scrapeserie':
					// Gets $keyword from $_POST
					$keyword = $_POST['keyword'];
					$this->scrapeSerie($keyword);
					break;
				case 'getrandomseries':
					// Gets $limit from $_POST
					$limit = $_POST['limit'];
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
			// Returns json to client
			$this->showJson($serie);
		}

	}

	/**
	 * getSeasons
	 *
	 * gets TV serie episodes from database by serie id
	 *
	 * @version  2.1
	 * @param    integer  $id  TV serie primary key
	 * @return   object        TV serie details
	 */
	public function getSeasons($id) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		$seasons = $defaultManager->findWhere($id, "serie_id", "episodes");

		// Returns json to client
		$this->showJson($seasons);
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