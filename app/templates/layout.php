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

	<!--h1 class="hidden-xs">SeriesManager <?= $this->e($title) ?></h1--> 

	<!--Navigation bar -->

 		<nav class="navbar navbar-default" role="navigation">
 		
 			<?= $this->section('header') ?> 

 			<!--Diaporama de la page home.php-->

  		<div class="container-fluid">
  			<div class="navbar-header">
  				
    	  		<!--burger-nav-->
			    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			   	</button>

			   	<!--logo-->
    	  		<a class="navbar-brand" href="#home">SM</a>

    	  		<button id="signIn" class="btn btn-default navbar-btn">Sign in</button>


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
					<input type="submit" value="Login" >
					
					<!-- logout -->
					<a href="<?php echo $this->url('password') ?>" title="Password">Password forgotten ?</a>
				</form>

				<a href="<?php echo $this->url('logout') ?>" title="Logout">Logout</a><br />

    		</div><!-- navbar-collapse -->
    		
		</div><!-- container-fluid-->
		
		</nav>


		<form class="navbar-form" role="search">
        	<div id="search-input" class="form-group">
          		<input type="text" class="form-control" placeholder="Search">
          	 </div>
    		<button type="submit" class="btn btn-default">Search</button>
      	</form>





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