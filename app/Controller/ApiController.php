<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Controls seriesmanager main api.
 *
 * API allow control of four main methods : searchSerie(), scrapeSerie(), getSerie() and getRandomSeries()
 *
 * User must provide the following arguments with the get method :
 * <pre>
 * $_GET['api_key']          As string   API key (fake)
 * $_GET['method']           As string   One of four methods availlable
 * $_GET['getserie']         As string   Returns TV serie details in json format
 * $_GET['id']               As integer  TV serie primary key
 * $_GET['searchserie']      As string   Searches for TV serie into database by title
 * $_GET['scrapeserie']      As string   Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
 * $_GET['getrandomseries']  As string   Sends random series from database in json format
 * $_GET['limit']            As integer  TV serie count to send to client
 * </pre>
 * @version 3.3.4
 * @last_modified    13:35 03/02/2016
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class ApiController extends Controller {
	/**
	 * Contains "notFound" serie array
	 * @var array
	 */
	protected $notFound;

	/**
	 * Initializes "notFound" property
	 * @version 1.0
	 */
	public function __construct() {

		// Sets "notFound" property options
		$this->notFound = [
				"id"           => 0,
				"imdb_id"      => null,
				"title"        => "Not Found",
				"poster_id"    => null,
				"summary"      => "Sorry the serie you requested could not be found.",
				"actors"       => null,
				"genre"        => "2015-2016 - CAMS Squad, Full Stack Web Developpers Team",
				"season_count" => 0,
				"start_date"   => null,
				"end_date"     => null,
				"seasons"      => null,
			];
	}

	/**
	 * Main seriesmanager API method.
	 * 
	 * Searches for TV serie into database by title
	 * Scrapes TV serie details from imdb when not present into database
	 * Returns TV serie details in json format
	 *
	 * User must provide the following arguments with the get method :
	 * <pre>
	 * $_GET['api_key']          As string   API key (fake)
	 * $_GET['method']           As string   One of four methods availlable
	 * $_GET['getserie']         As string   Returns TV serie details in json format
	 * $_GET['id']               As integer  TV serie primary key
	 * $_GET['searchserie']      As string   Searches for TV serie into database by title
	 * $_GET['scrapeserie']      As string   Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
	 * $_GET['getrandomseries']  As string   Sends random series from database in json format
	 * $_GET['limit']            As integer  TV serie count to send to client
	 * </pre>
	 * @version 1.1.4
	 * @api
	 * @return   array                              TV serie details
	 */
	public function seriesManager() {
		$defaultController = new \Controller\DefaultController();

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
					return 'Error : Invalid method';
			}
		} else {
			return 'Error : You need a valid api key to perform this action.';
		}
	}

	/**
	 * Searches for TV serie into database by title.
	 * 
	 * Returns TV serie details in json format (by primary key)
	 * @version 1.1
	 * @param    string  $keyword  TV serie title
	 * @return   object            TV series details
	 */
	public function searchSerie($keyword) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// Searches for TV serie into database by title
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
	 * Searches for TV serie by title and scrapes TV serie details from imdb when not present into database.
	 * 
	 * Adds TV serie details into database when found on imdb
	 * Returns TV serie details in json format (by primary key)
	 * @version 1.1.1
	 * @param    string  $title  TV serie title
	 * @return   array           TV serie details
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
				$this->showJson($this->notFound);
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
	 * Gets TV serie, seasons and episodes from database by id.
	 * 
	 * Returns TV serie details in json format (by primary key)
	 * @version 1.0.1
	 * @param    string  $id  TV serie title
	 * @return   array        TV series details
	 * @url                   http://localhost/seriesmanager/public/seriesmanagerapi?method=getserie&id=1&api_key=inwexrlzidlwncjfrrahtexduwskgtvk
	 */
	public function getSerie($id) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// Gets TV serie from database by id
		$serie = $defaultManager->findWhere($id, "id", "series");

		// When TV serie not present into database
		if (!$serie) {
			$this->showJson($this->notFound);
		} else {

			// Gets every season episode
			$seasons = $this->getSeasons($id, $serie["season_count"]);

			// Inserts seasons into $serie array
			$serie["seasons"] = $seasons;

			// Returns json to client
			$this->showJson($serie);
		}
	}

	/**
	 * Returns TV serie season and episodes from database by serie primary key and season
	 * @version 2.2.1
	 * @param       integer  $id           TV serie primary key
	 * @param       integer  $seasonCount  TV serie season count
	 * @return      array                  TV serie seasons and episodes
	 */
	protected function getSeasons($id, $seasonCount) {
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
	 * Sends random series from database in json format
	 * @version 1.3
	 * @param    integer  $limit  Series count to retrieve from database
	 * @return   array            TV serie details
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