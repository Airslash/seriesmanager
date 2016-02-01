<?php

namespace Controller;

use \W\Controller\Controller;

class EpisodeController extends Controller
{

	/**
	 * Page d'un épisode
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