<?php $this->layout('layout', ['title' => 'Episode']) ?>

<?php $this->start('main_content') ?>
	<h2>Episode</h2>

	<?php foreach ($episodes as $episode): ?>
	
		<div id="episode-info">
			<h4><?= $episode["title"] ?></h4>
			<img src="../assets/episodes_stills/<?= $episode["poster"] ?>" />
			<div id="episode-start">Original air date : <?= $episode["date"] ?></div>
			<div id="episode-description"><?= $episode["description"] ?></div>
		</div>
	
	<?php endforeach; ?>
	
<?php $this->stop('main_content') ?>
