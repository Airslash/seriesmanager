<?php $this->layout('layout', ['title' => 'Série']) ?>

<?php $this->start('main_content') ?>
	<h2>Série</h2>

	<?php foreach ($series as $serie): ?>
	
		<div id="serie-info">
			<h4><?= $serie["title"] ?></h4>
			<img src="covers/<?= $serie["poster"] ?>" />
			<div id="serie-description"><?= $serie["description"] ?></div>
			<div id="serie-genre"><?= $serie["genre"] ?></div>
			<div id="serie-actors"><?= $serie["actors"] ?></div>
		</div>
	
	<?php endforeach; ?>
	
<?php $this->stop('main_content') ?>
