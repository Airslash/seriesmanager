<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $this->e($title) ?></title>
	
	<link rel="stylesheet" href="<?= $this->assetUrl('css/normalize.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
</head>


<body>

	<div id="main-content">

<<<<<<< HEAD
	<!--h1 class="hidden-xs">SeriesManager <?= $this->e($title) ?></h1--> 
=======
>>>>>>> refs/remotes/origin/master
	<!--Navigation bar -->

 		<!-- <nav class="navbar navbar-default" role="navigation"> -->
 
  		<header class="container-fluid">

		   	<!--logo-->
	  		<a href="<?php echo $this->url('home') ?>" id="site-logo">
	  			<img src="<?= $this->assetUrl('img/logoSM.png') ?>" alt="logo">
  			</a>

			<!-- login -->
			<?php
				if (!empty($w_user)) {
					?>
					<p>Vous êtes connecté en tant que <?= $w_user['username'] ?></p>

<<<<<<< HEAD
			</div><!-- navbar-header -->

    		<!--Drop-down menu-->
			<div class="collapse navbar-collapse" id="menu">
		      	<ul class="nav navbar-nav">
			        <li class="active"><a href="<?php echo $this->url('home') ?>" title="Home">Home</a></li>
			        <li><a href="<?php echo $this->url('register') ?>" title="Register">Register</a></li>
			        <li><a href="<?php echo $this->url('profile') ?>" title="Profile">Profile</a></li>
		       	</ul>		
				
				<form action="<?php echo $this->url('login') ?>" method="POST">		
					<!-- login -->
					<input type="username" name="username" placeholder="Username">
			
					<input type="password" name="password" placeholder="Password">

					<a href="<?php echo $this->url('password') ?>" title="Password">Password forgotten ?</a>
=======
					<!-- logout -->
					<a href="<?php echo $this->url('logout') ?>" title="Logout">Logout</a><br />

				<?php
				}
				else{?>
				<form action="<?php echo $this->url('login') ?>" method="POST" id="log-form">		
					<div class="form-group">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<input type="username" name="username" placeholder="Username">
					</div>
					
					<div class="form-group">
						<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
						<input type="password" name="password" placeholder="Password">
					</div>

					<a href="<?php echo $this->url('password') ?>" title="Password">Forgot your password ?</a>
					<br />
					<input type="submit" value="Log In" >
>>>>>>> refs/remotes/origin/master
				</form>
				
				<?php 
				}
				?>
			



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


		
		
		<!--Diaporama de la page home.php-->
		<?= $this->section('header') ?> 


<<<<<<< HEAD
=======
		<!-- <form class="navbar-form" role="search">
		        	<div id="search-input" class="form-group">
		          		<input type="text" class="form-control" placeholder="Search">
		          	 </div>
		    		<button type="submit" class="btn btn-default">Search</button>
		      	</form>
		 -->




>>>>>>> refs/remotes/origin/master
		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>

	</div>




	<script src="<?= $this->assetUrl('js/jquery-1.12.0.min.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/masonry.pkgd.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

</body>
</html>