<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * SerieController   Controls all serie related data
 * @version          2.1.1 beta
 * @last_modified    16:34 01/02/2016
 * @author           Axel Merlin <merlin.axel@gmail.com>
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @method           autocompleteSerie  Searches for TV serie into database by title
 * @method           searchSerie        Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
 * @method           findSerie          Finds TV serie into database by id
 * @method           randomSerie        Sends random amount of series from database in json format
 * 
 */
class SerieController extends Controller {

	/**
	 * autocompleteSerie
	 *
	 * Searches for TV serie into database by title
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version  1.0 beta
	 * @param    string  $title  TV serie title
	 * @return   object          TV serie details
	 * @todo                     Accepter les requètes avec des espaces
	 */
	public function autocompleteSerie($title) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

	 	// Searches for TV serie into database by title
		$serie = $defaultManager->findLike($title, "title", "series");

		// When TV serie not present into database
		if (!$serie) {
			return false;
		} else {
			// Returns json to client
			$this->showJson($serie);
		}
	}

	/**
	 * searchSerie
	 *
	 * Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
	 * Adds TV serie details into database when found on imdb
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version  1.0 beta
	 * @param    string  $title  TV serie title
	 * @return   object          TV serie details
	 * @todo                     Accepter les requètes avec des espaces
	 */
	public function searchSerie($title) {
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
	 * findSerie
	 *
	 * Finds TV serie into database by id
	 *
	 * @version  1.1
	 * @param    integer  $id  TV serie primary key
	 * @return   object        TV serie details
	 */
	public function findSerie($id) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		$serie = $defaultManager->findWhere($id, "id", "series");

		// Returns json to client
		$this->showJson($serie);
	}

	/**
	 * randomSerie
	 *
	 * Sends random amount of series from database in json format
	 *
	 * @version  1.1
	 * @param    integer  $number  Series count to retrieve from database
	 * @return   object            TV serie details
	 */
	public function randomSeries($number) {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		for ($i=0; $i<$number; $i++) {
			$rowCount = $defaultManager->countRows("series");
			$randomSerieId = mt_rand(1, $rowCount);
			$serie = $defaultManager->findWhere($randomSerieId, "id", "series");
			if ($serie){
				$series[] = $serie[0];
			} else {
				$i--;
			}
		}

		// Returns json to client
		$this->showJson($series);
	}

	/**
	 * detail method
	 * @version               1.0
	 * @deprecated            1.0
 	 * @author                Axel Merlin <merlin.axel@gmail.com>
	 * @param    string  $id  TV serie title
	 * @return   object       TV serie details
	 */
	public function detail($id)	{
		$serieManager = new \Manager\SerieManager();

		$serie = $serieManager->find($id);

		$this->show('serie/detail', [
			"serie" => $serie
		]);
	}

	/**
	 * search method
	 * @version        1.0 beta
	 * @deprecated     1.0 beta
	 * @last_modified  21:09 31/01/2016
	 * @author         Axel Merlin <merlin.axel@gmail.com>
	 * @author         Matthias Morin <matthias.morin@gmail.com>
	 * @return object  Series from db
	 */
	public function search($title) {
		$serieManager = new \Manager\SerieManager();

		// Gets $keyword from $_GET
		// $keyword = $_GET['keyword'];

		$series = $serieManager->search($title);
		$this->show('serie/search', [
					"series" => $series
		]);
	}
}