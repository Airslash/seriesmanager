<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'home'],

		//page d'inscription
		['GET|POST', '/register/', 'User#register', 'register'],

		//page de détail d'une série
		['GET|POST', '/detail/', 'Serie#detail', 'detail'],

		//page de profil (avec liste des séries)
		['GET', '/profile/', 'Profile#profile', 'profile'],

		//page password
		['GET|POST', '/password/', 'User#password', 'password'],

		//page new password
		['GET|POST', '/new_password/[:token]/[:id]/', 'User#newPassword', 'new_password'],

		//page connexion 
		['GET|POST', '/login/', 'User#login', 'login'],

		//page de déconnexion
		['GET|POST', '/logout/', 'User#logout', 'logout'],

		//page de détail d'un épisode
		['GET', '/episode_detail/', 'Episode#episode_detail', 'episode_detail'],

		//page de scraping pour "hydrater" la base en masse
		['GET', '/scrape/', 'Scrape#scrape', 'scrape'],

		//page de recherche en autocomplétion
		['GET', '/search/', 'Search#search', 'search'],
	);