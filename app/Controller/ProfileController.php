<?php

namespace Controller;

use \W\Controller\Controller;

class ProfileController extends Controller
{

	/**
	 * Page de profil avec liste des séries
	 */
	public function profile()
	{

		$this->show('profile/profile');

	}
}