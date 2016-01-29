<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * SerieController   Controls all serie related stuff
 * @version          1.0
 * @last_modified    14:39 29/01/2016
 * @author           Axel Merlin <merlin.axel@gmail.com>
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class SerieController extends Controller {

	/**
	 * detail method
	 * @version  1.0
	 * @param    string $id TV serie title
	 * @return   object     TV serie details
	 */
	public function detail($id)	{
		$serieManager = new \Manager\SerieManager();

		$serie = $serieManager->find($id);

		$this->show('serie/detail', [
			"serie" => $serie
		]);
	}
}