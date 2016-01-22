<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
	<h1>Inscription</h1>


	<form method="POST" novalidate>
		
		<label for="username">Enter your username</label>	
		<input type="text" name="username" placeholder="Enter your username">
		<label for="email">Enter your email</label>
		<input type="email" name="email" placeholder="Enter your email">
		<label for="password">Enter your password</label>
		<input type="password" name="password" placeholder="Enter your password">
		<label for="password_bis">Confirm your password</label>
		<input type="password" name="password_bis" placeholder="Confirm your password">
		<!--?php echo $passwordError; ?-->
		<button type="submit">Register</button>

		</form>

<?php $this->stop('main_content') ?>
