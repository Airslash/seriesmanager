<?php $this->layout('layout', ['title' => 'Série']) ?>

<?php $this->start('main_content') ?>
	<h2>Série</h2>

	<?php foreach ($series as $serie): ?>
	
		<div id="serie-info">
			<h4><?= $serie["title"] ?></h4>
			<img src="../assets/img/<?= $serie["poster"] ?>" />
			<div id="serie-start"><?= $serie["start_date"] ?></div>
			<div id="serie-genre"><?= $serie["genre"] ?></div>
			<div id="serie-actors"><?= $serie["actors"] ?></div>
			<div id="serie-description"><?= $serie["description"] ?></div>
		</div>

		<a href="http://www.amazon.fr/s/ref=nb_sb_noss_2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&url=search-alias%3Daps&field-keywords=<?= $serie["title"] ?>" target="_blank">Amazon</a>

		<br />

		<a href="https://kat.cr/usearch/<?= $serie["title"] ?>/" target="_blank">Voir un extrait</a>
	
	<?php endforeach; ?>
	
<?php $this->stop('main_content') ?>
