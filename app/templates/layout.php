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

	<!--h1 class="hidden-xs">SeriesManager <?= $this->e($title) ?></h1--> 

<<<<<<< HEAD

	<!--Navigation bar -->

 		<nav class="navbar navbar-default" role="navigation">
 		
 			<?= $this->section('header') ?> <!--Diaporama de la page home.php-->


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
			        <li class="active"><a href="<?php echo $this->url('home') ?>" title="Accueil">Home</a></li>
			        <li><a href="<?php echo $this->url('register') ?>" title="Inscription">Register</a></li>
			        <li><a href="<?php echo $this->url('profile') ?>" title="Profile">Profile</a></li>
		       	</ul>
=======
			<nav>
				<ul class="nav nav-tabs">
					<li><a href="<?php echo $this->url('home') ?>" title="Home">Home</a></li>
					<li><a href="<?php echo $this->url('register') ?>" title="Signin">Register</a></li>

					<li><a href="<?php echo $this->url('profile') ?>" title="Profile">Profile</a></li>
				
				<form action="<?php echo $this->url('login') ?>" method="POST">
					<input type="username" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<input type="submit" value="Login" />

					<a href="<?php echo $this->url('password') ?>" title="Password">Password forgotten ?</a>
				</form>
>>>>>>> origin/master


      		<!--form class="navbar-form navbar-left" role="search">
        	<div class="form-group">
          		<input type="text" class="form-control" placeholder="Search">
        	</div>
        	<button type="submit" class="btn btn-default">Submit</button>
      		</form-->

    		</div><!-- navbar-collapse -->
    		
		</div><!-- container-fluid-->
		
		</nav>


		<form class="navbar-form" role="search">
        	<div class="form-group">
          		<input type="text" class="form-control" placeholder="Search">
          	 </div>
    			<button type="submit" class="btn btn-default">Submit</button>
      	</form>




	<!--div class="container-fluid"

				<button id="signIn" class="btn btn-default navbar-btn">Sign in</button>

			</div>
			</nav>

					<input type="username" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<button type="submit">Login</button>

				
		</header!-->

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	<!--/div-->

	<script src="<?= $this->assetUrl('js/jquery-1.12.0.min.js') ?>"></script>
<<<<<<< HEAD
	<script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
=======
	<script src="<?= $this->assetUrl('js/masonry.pkgd.js') ?>"></script>
>>>>>>> origin/master
	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

</body>
</html>