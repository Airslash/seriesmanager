<?php foreach ($series as $serie): ?>

	<div id="serie-info">
		<a href="detail/<?= $serie['id'] ?>/"><img src="http://ia.media-imdb.com/images/M/<?= $serie["poster_id"] ?>@._V1._SY74_CR0,0,54,74_.jpg" /><?= $serie["title"] ?> <br />(<?= $serie["start_date"] ?>)</a>
	</div>

<?php endforeach; ?>
