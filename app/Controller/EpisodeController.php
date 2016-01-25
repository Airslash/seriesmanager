<?php

namespace Controller;

use \W\Controller\Controller;

class EpisodeController extends Controller
{

	/**
	 * Page d'un épisode
	 */
	public function episode_detail()
	{
		$episodeManager = new \Manager\EpisodeManager();

		$episodes = $episodeManager->findAll();

		$this->show('episode/episode_detail', [
			"episodes" => $episodes
		]);
	}

}