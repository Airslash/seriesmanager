<?php $this->layout('layout', ['title' => 'Série']) ?>

<?php $this->start('main_content') ?>
	<h2>Série</h2>

		<div id="serie-info">
			<h4><?= $serie["title"] ?></h4>
			<img src="http://ia.media-imdb.com/images/M/<?= $serie["poster_id"] ?>._V1_SX640_SY720_.jpg" />
			<div id="serie-start"><?= $serie["start_date"] ?></div>
			<div id="serie-genre"><?= $serie["genre"] ?></div>
			<div id="serie-actors"><?= $serie["actors"] ?></div>
			<div id="serie-summary"><?= $serie["summary"] ?></div>
		</div>

		<a href="http://www.amazon.fr/s/ref=nb_sb_noss_2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&url=search-alias%3Daps&field-keywords=<?= $serie["title"] ?>" target="_blank">Amazon</a>

		<br />

		<a href="https://kat.cr/usearch/<?= $serie["title"] ?>/" target="_blank">Get torrents</a>

	
<?php $this->stop('main_content') ?>