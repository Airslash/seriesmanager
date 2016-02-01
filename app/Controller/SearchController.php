<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * SearchController  Controls searches
 * @version          1.0
 * @last_modified    14:22 29/01/2016
 * @author           Axel Merlin <merlin.axel@gmail.com>
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class SearchController extends Controller {

	/**
	 * search method
	 * @version        1.0 beta
	 * @last_modified  21:09 31/01/2016
	 * @author         Axel Merlin <merlin.axel@gmail.com>
	 * @author         Matthias Morin <matthias.morin@gmail.com>
	 * @return object  Series from db
	 */
	public function search() {
		$serieManager = new \Manager\SerieManager();

		// Gets $keyword from $_GET
		$keyword = $_GET['keyword'];

		$series = $serieManager->search($keyword);
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