<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>

	<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
</head>
<body>
	<div class="container">
		<header>

			<h1>SeriesManager :: <?= $this->e($title) ?></h1>

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

				</ul>
			</nav>

			
		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	</div>

	<script src="<?= $this->assetUrl('js/jquery-1.12.0.min.js') ?>"></script>

</body>
</html>