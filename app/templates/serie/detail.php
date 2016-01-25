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
	
	<?php endforeach; ?>
	
<?php $this->stop('main_content') ?>
