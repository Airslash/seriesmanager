<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * SerieController   Controls all serie related data
 * @version          2.1 beta
 * @last_modified    13:42 01/02/2016
 * @author           Axel Merlin <merlin.axel@gmail.com>
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class SerieController extends Controller {

	/**
	 * detail method
	 * @version  1.0
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
	 * searchSerie
	 *
	 * Searches for TV serie into database by title
	 * Scrapes TV serie details from imdb when not present
	 * and adds TV serie details into database
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version  1.0 beta
	 * @param    string  $title  TV serie title
	 * @return   object          TV serie details
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
	 * search method
	 * @version        1.0 beta
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