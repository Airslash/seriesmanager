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
<<<<<<< HEAD
			<h1>W :: <?= $this->e($title) ?></h1>
			<nav>
				<ul class="nav nav-tabs">
					<li><a href="<?php echo $this->url('home') ?>" title="Accueil">Accueil</a></li>
					<li><a href="<?php echo $this->url('register') ?>" title="Inscription">Inscription</a></li>
				</ul>
			</nav>
=======
			<h1>SeriesManager :: <?= $this->e($title) ?></h1>
>>>>>>> origin/master
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