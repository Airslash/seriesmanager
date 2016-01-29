
	<?php foreach ($series as $serie): ?>
	
		<div id="serie-info">
			<a href="detail/<?= $serie['id'] ?>/"><?= $serie["title"] ?></a>
		</div>
	<?php endforeach; ?>
