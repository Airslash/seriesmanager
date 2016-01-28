<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $this->e($title) ?></title>
	
	<link rel="stylesheet" href="<?= $this->assetUrl('css/normalize.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>


<body>

	<div id="main-content" class="container-fluid">

 		<!-- <nav class="navbar navbar-default" role="navigation"> -->
 
  		<header>

		   	<!--logo-->
	  		<a href="<?php echo $this->url('home') ?>" id="site-logo">
	  			<img src="<?= $this->assetUrl('img/logoSM.png') ?>" alt="logo">
  			</a>

			<!-- login -->
			<div id="log-nav">
			<?php
				if (!empty($w_user)) {
					?>
					<p>You are logged as <?= $w_user['username'] ?></p>

					<!-- logout -->
					<a href="<?php echo $this->url('logout') ?>" title="Logout">Logout</a><br />
			<?php
			}
			else {?>				
				<form action="<?php echo $this->url('login') ?>" method="POST" id="log-form">		
					<div class="form-group">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<input type="username" name="username" placeholder="Username">
					</div>
					
					<div class="form-group">
						<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
						<input type="password" name="password" placeholder="Password">
						<a href="<?php echo $this->url('password') ?>" title="Password" id="pw-forgot">Forgot your password ?</a>
					</div>

					<input type="submit" value="Log In" id="login-input">

				</form>
				<?php 
				}
				?>
			</div>
			
    		<!--menu-->
    		<?php
    			if (!empty($w_user)) {
    				?>
		    		<div id="menu">
			    		<ul class="nav nav-tabs">
			    		  <li role="navigation"><a href="<?php echo $this->url('home') ?>" title="Home">Home</a></li>
			    		  <li role="navigation"><a href="<?php echo $this->url('profile') ?>">Profile</a></li>
			    		</ul>
		    		</div>
	    		<?php
	    		}
	    		else{?>
		    		<div id="menu-logout">
			    		<ul class="nav nav-tabs">
			    		  <li role="navigation"><a href="<?php echo $this->url('home') ?>" title="Home">Home</a></li>
			    		  <li role="navigation"><a href="<?php echo $this->url('register') ?>">Register</a></li>
			    		</ul>
		    		</div>
	    		<?php 
	    		}
	    		?>
    		
		</header><!-- container-fluid-->

		<form action="<?= $this->url('search') ?>" method="GET" id="serie-search-form">
			<input type="search" name="keyword" id="keyword-input" class="form-control" placeholder="Titre, acteurs...">
		</form>
		<div id="result-search"></div>

		
		<!--Diaporama de la page home.php-->
		<?= $this->section('header') ?> 

		
		<section>
			<?= $this->section('main_content') ?>
		</section>

		</div>

		<footer>
			<p><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> SeriesManager</p>
			<p>Made by CAMS Squad</p>
		</footer>

	


	<script src="<?= $this->assetUrl('js/jquery-1.12.0.min.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/masonry.pkgd.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

</body>
</html>