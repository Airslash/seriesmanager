<?php $this->layout('layout', ['title' => 'Episode']) ?>

<?php $this->start('main_content') ?>

	<div id="episode-info">
		<h2><?= $episode["title"] ?></h2>
		<div id="season-episode">Season <?= $episode["season"] ?>, Episode <?= $episode["episode"] ?></div>
		<img src="http://ia.media-imdb.com/images/M/<?= $episode["poster_id"] ?>._V1_SX640_SY720_.jpg" />
		<div class="detail-serie">
			<div id="episode-start">Original air date : <?= $episode["air_date"] ?></div>
			<div id="episode-summary"><?= $episode["summary"] ?></div>
		</div>
	</div>
	
	
<?php $this->stop('main_content') ?>
