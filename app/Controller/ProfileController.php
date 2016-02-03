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
		if (!$this->getUser()){
			$this->redirectToRoute("register");
		}
		$this->show('profile/profile');


	}
}