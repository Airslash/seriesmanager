<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * DefaultController
 * 
 * Extends W framework Controller with cool new functionalities
 * 
 * @version        1.2
 * @last_modified  15:28 02/02/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @method         home Default  home page
 * @method         showPrint_r   Displays raw array data
 */
class DefaultController extends Controller {

	/**
	 * home
	 * 
	 * Page d'accueil par défaut
	 *
	 * @version  1.0
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