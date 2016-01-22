<?php

namespace Controller;

use \W\Controller\Controller;

class UserController extends Controller
{

	/**
	 * Page d'inscription
	 */
	public function register()
	{

	$this->show('user/register');

	}
}
			

// Vérification de formulaire
// Email déjà existant
// mot de passe etc... une fois base de données prête