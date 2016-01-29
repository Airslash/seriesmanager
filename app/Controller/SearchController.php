<?php

namespace Controller;

use \W\Controller\Controller;

class SearchController extends Controller
{
	public function search() 
	{
		$serieManager = new \Manager\SerieManager();

		$series = $serieManager->search();

		$this->show('serie/search', [
					"series" => $series
		]);
	}
}