<?php

namespace Controller;

use \W\Controller\Controller;

class SerieController extends Controller
{

	/**
	 * Page d'une série
	 */
	public function detail($id)
	{
		$serieManager = new \Manager\SerieManager();

		$serie = $serieManager->find($id);

		$this->show('serie/detail', [
			"serie" => $serie
		]);
	}

}