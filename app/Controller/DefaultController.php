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

	/**
	 * showPrint_r
	 * 
	 * Displays raw array data
	 * 
	 * @param  array  $array  array data
	 */
	public function showPrint_r($array) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
}