<?php $this->layout('layout', ['title' => 'Lost ?']) ?>

<?php $this->start('main_content'); ?>
<div class="background">
	<h1>Error 404. Lost ?</h1>
	<img src="<?= $this->assetUrl('img/lost.jpg') ?>" >
</div>
<?php $this->stop('main_content'); ?>
