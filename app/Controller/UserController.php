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

		$passwordError = "";

		// Vérification de formulaire
		if ($_POST){
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$password_bis = $_POST['password_bis'];

			// validation des données
			$isValid = true;

			if ($password != $password_bis){
				$isValid = false;
				$passwordError = "Le mot de passe ne correspond pas !";
			}

			$userManager = new \Manager\UserManager();

			// Email déjà existant
			if ($userManager->emailExists($email) ){
				$isValid = false;
				$passwordError = "Email déjà utilisé !";
			}

			// si c'est valide
			if ($isValid){
				// insertion en bdd
				$userManager->insert([
					"username" => $username,
					"email" => $email,
					"password" => password_hash($password, PASSWORD_DEFAULT)
				]);

				// redirection de l'utilisateur
				$this->redirectToRoute("home"); 
			}
			else {
				// invalide, on veut afficher des erreurs
			}
		}

		$this->show('user/register', [
			"passwordError" => $passwordError
		]);

	}
}