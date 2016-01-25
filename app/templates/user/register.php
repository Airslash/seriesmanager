<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
	<h1>Register</h1>


	<form method="POST" novalidate>
		
		<label for="username">Enter your username</label>	
		<input type="text" name="username" placeholder="Enter your username"><br />
		<label for="email">Enter your email</label>
		<input type="email" name="email" placeholder="Enter your email"><br />
		<label for="password">Enter your password</label>
		<input type="password" name="password" placeholder="Enter your password"><br />
		<label for="password_bis">Confirm your password</label>
		<input type="password" name="password_bis" placeholder="Confirm your password">
		<?php echo $passwordError; ?><br />
		<button type="submit">Register</button>

		</form>

<?php $this->stop('main_content') ?>
