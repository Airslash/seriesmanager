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
class SearchController extends Controller
{
	public function search() 
	{
		$serieManager = new \Manager\SerieManager();

		// Gets $keyword from $_GET
		$keyword = $_GET['keyword'];

		$series = $serieManager->search($keyword);
		$this->show('serie/search', [
					"series" => $series
		]);
	}
}