<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * SerieController   Controls all serie related stuff
 * @version          2.0
 * @last_modified    14:39 29/01/2016
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
	 * test method
	 * @version  1.0 beta
	 * @param    string  $id  TV serie title
	 * @return   object       TV serie details
	 */
	public function test($title)	{
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// $serie = $defaultManager->superFind($title, "title", "series");
		$serie = $defaultManager->superSearch($title, "title", "series");

		$defaultController->showPrint_r($serie);
	}

	public function test2($title)	{
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		$serie = $defaultManager->superFind($title, "title", "series");

		$defaultController->showPrint_r($serie);
	}

	/**
	 * getSerie
	 *
	 * Checks if TV serie is present into database (by title)
	 * Scrapes TV serie details from imdb when not present
	 * and adds TV serie details into database
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version                  1.0.1 beta
	 * @param    string  $title  TV serie title
	 */
	public function getSerie($title) {
		// Initializes objects
		$defaultManager = new \Manager\DefaultManager();
		$imdbScraper    = new \Scraper\ImdbScraper();

		// Gets serie from database
		$serie = $serieManager->superSearch($title, "title", "series");

		// When TV serie not present into database
		if (!$serie) {
			// Scrapes TV serie (by title)
			$imdbScraper->scrapeSerie($title);
		}

		// gets TV serie details from database
		$serie = $defaultManager->superFind($title, "title", "series");
	}

	/**
	 * addSerie
	 *
	 * Scrapes TV serie details from imdb
	 * And adds TV serie details into database
	 *
	 * @version                  1.0 beta
	 * @param    string  $title  TV serie title
	 */
	public function addSerie($title) {
		$serieManager = new \Manager\SerieManager();

		$serie = $serieManager->superFind("title", $title);
		if ($serie) {
			
		}
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

	/**
	 * supersearch method
	 * @version        1.0 beta
	 * @last_modified  21:09 31/01/2016
	 * @author         Matthias Morin <matthias.morin@gmail.com>
	 * @return object  table from db
	 */
	public function jsonSearch() {
		$serieManager = new \Manager\SerieManager();

		// Gets $keyword from $_GET
		$table  = $_GET['table'];
		$column = $_GET['column'];
		$search = $_GET['search'];

		$series = $serieManager->superSearch($search, $column, $table);
		$this->showJson($series);
	}

}