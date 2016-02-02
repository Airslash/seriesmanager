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
 * @method           seriesManagerApi  Main seriesmanager API
 * @method           searchSerie       Searches for TV serie into database by keyword
 * @method           randomSerie       Sends random series from database in json format
 * @method           scrapeSerie       Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
 * @method           findSerie         Finds TV serie into database by id
 * @method           randomSerie       Sends random amount of series from database in json format
 * @todo                               namespace?
 *
 */
class SerieController extends Controller {

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