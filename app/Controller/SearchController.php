<?php

namespace Controller;

use \W\Controller\Controller;

class SearchController extends Controller
{
	public function search() 
	{
		$serieManager = new \Manager\SerieManager();

		$series = $serieManager->findAll();

		$this->show('serie/detail', [
					"series" => $series
		]);
	}
}