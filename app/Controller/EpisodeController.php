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
		if (!$this->getUser()){
			$this->redirectToRoute("register");
		}
		$episodeManager = new \Manager\EpisodeManager();

		$episode = $episodeManager->find($id);

		$this->show('episode/episode_detail', [
			"episode" => $episode
		]);
	}
}