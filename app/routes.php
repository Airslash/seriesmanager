<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'home'],

		//page d'inscription
		['GET|POST', '/register/', 'User#register', 'register'],

		//page de détail d'une série
		['GET|POST', '/detail/', 'Serie#detail', 'detail'],
	);