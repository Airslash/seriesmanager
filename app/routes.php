<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'home'],

		//page d'inscription
		['GET|POST', '/register/', 'User#register', 'register'],

		//page de détail d'une série
		['GET|POST', '/detail/', 'Serie#detail', 'detail'],

		//page de profil (avec liste des séries)
		['GET', '/profile/', 'Profile#profile', 'profile'],

<<<<<<< HEAD
		//page mot de passe oublié
		['GET', '/password/', 'User#password', 'password'],

		//page connexion 
		['GET|POST', '/login/', 'User#login', 'login'],

		//page de déconnexion
		['GET|POST', '/logout/', 'User#logout', 'logout'],

=======
		//page de détail d'un épisode
		['GET', '/episode_detail/', 'Episode#episode_detail', 'episode_detail'],
>>>>>>> origin/master
	);