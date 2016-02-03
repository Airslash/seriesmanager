<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * SerieController   Controls all serie related data
 * @version          3.0 beta
 * @last_modified    12:36 02/02/2016
 * @author           Axel Merlin <merlin.axel@gmail.com>
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class SerieController extends Controller {

	/**
	 * detail method
	 * @version               1.0
	 * @deprecated            1.0
	 * @author                Axel Merlin <merlin.axel@gmail.com>
	 * @param    string  $id  TV serie title
	 * @return   object       TV serie details
	 */
	public function detail($id)	{
		if (!$this->getUser()){
			$this->redirectToRoute("login");
		}
		$serieManager = new \Manager\SerieManager();
		$serie = $serieManager->find($id);
		$userManager = new \Manager\UserManager();
		$foundBookmark = $userManager->isInCollection($id);
		$this->show('serie/detail', [
			"serie" => $serie,
			"foundCollection" => $foundBookmark
		]);
	}

	public function addToCollection($id) {
		if (!$this->getUser()){
			$this->redirectToRoute("login");
		}
		$user=$this->getUser();
		$bookmarkManager = new \Manager\BookmarkManager();
		$bookmarkManager->insert([
			"user_id" => $user["id"],
			"serie_id" => $id,
		]);
		$this->redirectToRoute("detail", ["id"=>$id]);
	}

	public function removeFromCollection($id) {
		if (!$this->getUser()){
			$this->redirectToRoute("login");
		}
		$user=$this->getUser();
		$bookmarkManager = new \Manager\BookmarkManager();
		$bookmarkManager->delete([
			"user_id" => $user["id"],
			"serie_id" => $id,
		]);
		$this->redirectToRoute("detail", ["id"=>$id]);
	}


	/**
	 * search method
	 * @version        1.0 beta
	 * @deprecated     1.0 beta
	 * @last_modified  21:09 31/01/2016
	 * @author         Axel Merlin <merlin.axel@gmail.com>
	 * @author         Matthias Morin <matthias.morin@gmail.com>
	 * @return object  Series from db
	 */
	public function search($title) {
		$serieManager = new \Manager\SerieManager();

		// Gets $keyword from $_GET
		// $keyword = $_GET['keyword'];

		$series = $serieManager->search($title);
		$this->show('serie/search', [
					"series" => $series
		]);
	}
}