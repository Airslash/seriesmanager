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
					<li><a href="<?php echo $this->url('home') ?>" title="Accueil">Accueil</a></li>
					<li><a href="<?php echo $this->url('register') ?>" title="Inscription">Inscription</a></li>

					<input type="username" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<button type="submit">Login</button>

					<li><a href="<?php echo $this->url('profile') ?>" title="Profile">Profile</a></li>

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
	<script src="<?= $this->assetUrl('js/masonry.pkgd.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

</body>
</html>