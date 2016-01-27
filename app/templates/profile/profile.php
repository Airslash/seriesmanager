<?php $this->layout('layout', ['title' => 'Profile']) ?>

<?php $this->start('main_content') ?>

	<h1>My profile</h1>
		<h2>My favorite tv-shows</h2>
<?php print_r($w_user); ?>
<?php $this->stop('main_content') ?>
