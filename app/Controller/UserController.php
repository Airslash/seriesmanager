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
				var_dump($result);
			// on le connecte
				$authentificationManager->logUserIn($user);
			} 

			else {

				die("wrong id");
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

	/**
	 *  page password oublié
	 */

	public function password()
	{
		// formulaire 
		if ($_POST){
			$email = $_POST['email'];

			$userManager = new \Manager\UserManager();

			if ($userManager->emailExists($email) ){

				require 'PHPMailerAutoload.php';

				//Create a new PHPMailer instance
				$mail = new PHPMailer();
				//Tell PHPMailer to use SMTP
				$mail->IsSMTP();
				//Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				$mail->SMTPDebug  = 2;
				//Ask for HTML-friendly debug output
				$mail->Debugoutput = 'html';
				//Set the hostname of the mail server
				$mail->Host       = 'smtp.gmail.com';
				//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
				$mail->Port       = 465;
				//Set the encryption system to use - ssl (deprecated) or tls
				$mail->SMTPSecure = 'ssl';
				//Whether to use SMTP authentication
				$mail->SMTPAuth   = true;
				//Username to use for SMTP authentication - use full email address for gmail
				$mail->Username   = 'christian.marcucci13@gmail.com';
				//Password to use for SMTP authentication
				$mail->Password   = '######';
				//Set who the message is to be sent from
				$mail->SetFrom('christian.marcucci13@gmail.com', 'First Last');
				//Set who the message is to be sent to
				$mail->AddAddress('merlin.axel@gmail.com', 'John Doe');
				//Set the subject line
				//$mail->Subject = 'PHPMailer GMail SMTP test';
				//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
				$mail->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
				//Replace the plain text body with one created manually
				$mail->AltBody = 'Hello darkness my old friend';
				 
				//Send the message, check for errors
				if(!$mail->Send()) {
				  echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
				  echo 'Message sent!';
				}
			}

		}

		else {

		}

		$this->show("user/password");
	}


	/**
	 *  page new password
	 */

	public function newPassword()
	{
		$userManager = new \Manager\UserManager();

		$this->show("user/new_password");
	}


}