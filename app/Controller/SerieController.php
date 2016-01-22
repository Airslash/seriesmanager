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
		$this->show('serie/detail');
	}

}