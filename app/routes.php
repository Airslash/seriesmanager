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

		// ****
		// HOME
		// ****

		['GET', '/', 'Default#home', 'home'],


		// ***********
		// FORMULAIRES
		// ***********

		// Page d'inscription
		['GET|POST', '/register/', 'User#register', 'register'],

		// Page password
		['GET|POST', '/password/', 'User#password', 'password'],

		// Page new password
		['GET|POST', '/new_password/[:token]/[:id]/', 'User#newPassword', 'new_password'],

		// Page connexion
		['GET|POST', '/login/', 'User#login', 'login'],

		// Page de déconnexion
		['GET|POST', '/logout/', 'User#logout', 'logout'],


		// ***********************************
		// Affichage par le moteur de template
		// ***********************************

		// Page de profil (avec liste des séries)
		['GET', '/profile/', 'Profile#profile', 'profile'],

		// Affichage d'une serie
		['GET|POST', '/findserie/[i:id]/', 'Serie#findSerie', 'find_serie'],

		// Page de détail d'un épisode
		['GET', '/episode_detail/[:id]/', 'Episode#episode_detail', 'episode_detail'],


		// ***
		// API
		// ***

		// Route de l'API principale
		['GET|POST', '/seriesmanagerapi', 'Api#seriesManager', 'api'],


		// ***********
		// BACK OFFICE
		// ***********

		/**
		 * scraper
		 * Page de scraping pour "hydrater" la base en masse
		 * For back-office only
		 */
		['GET|POST', '/scraper/[i:from]/[i:to]/', 'Scraper#scrapeMostPopularSeries', 'scraper'],

		/**
		 * scrapeserie
		 * Ajout d'une serie dans la base
		 * For back-office only
		 */
		['GET|POST', '/scrapeserie/[:title]/', 'Scraper#scrapeSerie', 'scrapeserie'],


		// ****************
		// NE PLUS UTILISER
		// ****************

		/**
		 * searchserie
		 * Affichage de series au hazard
		 * @deprecated 1.0
		 */
		['GET|POST', '/randomseries/[i:number]/', 'Serie#getRandomSeries', 'random_serie'],


		/**
		 * searchserie
		 * Recherche d'une serie
		 * @deprecated 1.0
		 */
		['GET|POST', '/searchserie/[:title]/', 'Serie#searchSerie', 'search_serie'],

		/**
		 * detail
		 * Page de détail d'une série
		 * @deprecated 1.0
		 */
		['GET|POST', '/detail/[:id]/', 'Serie#detail', 'detail'],

		/**
		 * search
		 * Page de recherche en autocomplétion
		 * @deprecated 1.0
		 */
		['GET|POST', '/search/[:title]', 'Serie#search', 'search'],

		/**
		 * test
		 * Affichage d'un test
		 * @deprecated 1.0
		 */
		['GET|POST', '/test', 'Test#test', 'test'],
	);