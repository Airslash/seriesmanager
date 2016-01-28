<?php

namespace Controller;

use \W\Controller\Controller;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

	public function search()
	{
		$serieManager = new \Manager\SerieManager();

		$series = $serieManager->findAll();

		$this->show('layout', [
			"series" => $series
		]);
	}
}