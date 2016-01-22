<?php

namespace Controller;

use \W\Controller\Controller;

class SerieController extends Controller
{

	/**
	 * Page d'une série
	 */
	public function detail()
	{
		$serieManager = new \Manager\SerieManager();

		$series = $serieManager->findAll();

		$this->show('serie/detail', [
			"series" => $series
		]);
	}

}