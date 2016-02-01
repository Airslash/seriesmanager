<?php

namespace Controller;

use \W\Controller\Controller;

class EpisodeController extends Controller {

	/**
	 * episode_detail
	 * 
	 * Page d'un épisode
	 * @version  1.0
	 */

	public function episode_detail($id)
	{
		$episodeManager = new \Manager\EpisodeManager();

		$episode = $episodeManager->find($id);

		$this->show('episode/episode_detail', [
			"episode" => $episode
		]);
	}

}