<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * SerieController   Controls all serie related stuff
 * @version          1.0
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

		// Gets serie from database
		$serie = $serieManager->superSearch($title, "title", "series");

		// When TV serie not present into database
		if (!$serie) {
			// Scraping TV serie (by name)
			
		} else {

		}
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


}