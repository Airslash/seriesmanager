<?php

namespace Controller;

use \W\Controller\Controller;

class EpisodeController extends Controller
{

	/**
	 * episode_detail
	 * 
	 * Page d'un épisode
	 * @version  1.0
	 */
	public function episode_detail() {
		$episodeManager = new \Manager\EpisodeManager();
		$episodes = $episodeManager->findAll();
		$this->show('episode/episode_detail', [
			"episodes" => $episodes
		]);
	}

}