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
		$scraper = new \Scraper\ImdbScraper("Les hauts et les bas de Sophie Paquin");
		$this->show('default/home');
	}
}