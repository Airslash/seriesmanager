<?php $this->layout('layout', ['title' => 'password']) ?>

<?php $this->start('main_content') ?>

<form method="POST">
	<input type="email" name="email" placeholder="Enter your email">
	<input type="submit" value="Recover">
</form>

<?php $this->stop('main_content') ?>