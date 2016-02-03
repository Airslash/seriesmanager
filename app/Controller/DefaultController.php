<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * DefaultController
 */
class DefaultController extends Controller {

	/**
	 * Page d'accueil par défaut
	 */
	public function home() {
		$this->show('default/home');
	}

	/**
	 * Page mentions légales
	 */
	public function legal()
	{
		$this->show('default/legal');
	}

	/**
	 * Page about
	 */
	public function about()
	{
		$this->show('default/about');
	}

	/**
	 * showPrint_r
	 * 
	 * Displays raw array data
	 *
	 * @version       1.0
	 * @deprecated    1.0
	 * @param  array  $array  array data
	 */
	public function showPrint_r($array) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
}