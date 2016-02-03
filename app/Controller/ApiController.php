<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * ApiController
 *
 * Controls seriesmanager main api
 *
 * @version          3.3.3
 * @last_modified    23:46 02/02/2016
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @method           seriesManager     Main seriesmanager API method
 * @method           getSerie          Gets TV serie, seasons and episodes from database by id
 * @method           getSeasons        Returns TV serie season and episodes from database by serie primary key and season
 * @method           searchSerie       Searches for TV serie into database by title
 * @method           scrapeSerie       Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
 * @method           getRandomSeries   Sends random series from database in json format
 */
class ApiController extends Controller {
	/**
	 * Property
	 * Contains not found serie object
	 * @var array
	 */
	protected $notFound;

	/**
	 * Constructor
	 * 
	 * Initializes notFound property
	 * 
	 * @version  1.0
	 */
	public function __construct() {

		// Sets notFound property options
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
	 * seriesManager
	 *
	 * Main seriesmanager API method
	 * Searches for TV serie into database by title
	 * Scrapes TV serie details from imdb when not present into database
	 * Returns TV serie details in json format
	 *
	 * @version  1.1.3
	 * @api
	 * @assumes  string   $_GET['api_key']          API key (fake)
	 * @assumes  string   $_GET['method']           One of five methods availlable
	 * @assumes  string   $_GET['getserie']         Returns TV serie details in json format
	 * @assumes  integer  $_GET['id']               TV serie primary key
	 * @assumes  string   $_GET['searchserie']      Searches for TV serie into database by title
	 * @assumes  string   $_GET['scrapeserie']      Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
	 * @assumes  string   $_GET['getrandomseries']  Sends random series from database in json format
	 * @assumes  integer  $_GET['limit']            TV serie count to send to client
	 * @return   object                             TV serie details
	 * @todo                                        Demander à Guillaume pour retour d'erreurs
	 * @todo                                        Demander à Guillaume pour PHPDocumentor
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
	 * searchSerie
	 *
	 * Searches for TV serie into database by title
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version  1.1
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
	 * getSerie
	 *
	 * Gets TV serie, seasons and episodes from database by id
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version               1.0 beta
	 * @param    string  $id  TV serie title
	 * @return   object       TV series details
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
	 * getSeasons
	 *
	 * Returns TV serie season and episodes from database by serie primary key and season
	 *
	 * @version                   2.2.1
	 * @param       integer  $id  TV serie primary key
	 * @return      object        TV serie seasons and episodes
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