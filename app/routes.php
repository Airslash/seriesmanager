<?php

	/**
	 * Routes
	 * http://localhost/W/docs/tuto/?p=routes
	 * 
	 * "GET|POST"          HTTP resquest method
	 * "/services/"        URL mask
	 * "Default#services"  Controller name and method to call
	 * "default_services"  Route name (must be unique)
	 */

	$w_routes = array(
		['GET', '/', 'Default#home', 'home'],

		// Page d'inscription
		['GET|POST', '/register/', 'User#register', 'register'],

		// Page de détail d'une série
		['GET|POST', '/detail/[:id]/', 'Serie#detail', 'detail'],

		// Page de profil (avec liste des séries)
		['GET', '/profile/', 'Profile#profile', 'profile'],

		// Page password
		['GET|POST', '/password/', 'User#password', 'password'],

		// Page new password
		['GET|POST', '/new_password/[:token]/[:id]/', 'User#newPassword', 'new_password'],

		// Page connexion
		['GET|POST', '/login/', 'User#login', 'login'],

		// Page de déconnexion
		['GET|POST', '/logout/', 'User#logout', 'logout'],

		// Page de détail d'un épisode
		['GET', '/episode_detail/', 'Episode#episode_detail', 'episode_detail'],

		// Page de recherche en autocomplétion
		['GET', '/search/[:title]', 'Serie#search', 'search'],

		// Page de scraping pour "hydrater" la base en masse
		['GET', '/scraper/[i:pages]/', 'Scraper#scrapeMostPopularSeries', 'scraper'],

		// Page de détail d'un épisode
		['GET|POST', '/test/[:title]/', 'Serie#test', 'test'],

		['GET|POST', '/test2/[:title]/', 'Serie#test2', 'test2'],

		// Page d'ajout manuel de série
		// ['GET', '/addserie/[:serie]', 'Serie#addSerie', 'addserie'],

		// Page de recherche json
		// ['GET|POST', '/jsonsearch/[:serie]', 'Search#jsonSearch', 'jsonsearch'],
	);