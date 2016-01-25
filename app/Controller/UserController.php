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

	/**
	 * Page de connexion
	 */

	public function login()
	{
		if (!empty($_POST)){
			$username = $_POST['username'];
			$password = $_POST['password'];

			$authentificationManager = new \W\Security\AuthentificationManager;
			$result = $authentificationManager->isValidLoginInfo( $username, $password);
			// connexion réussie
			if ($result){
				// on récupère le user en base de données
				$userManager = new \Manager\UserManager;
				$user = $userManager->find($result);
				
			// on le connecte
				$authentificationManager->logUserIn($user);
			}
			// mauvais identifiant
			else {
				echo "Wrong id";
			}
		}

		$this->show("user/login");
	}

	/**
	 * Page de déconnexion
	 */

	public function logout()
	{
		$authentificationManager = new \W\Security\AuthentificationManager;

		$authentificationManager->logUserOut();


		$this->show("user/logout");
	}
	

}