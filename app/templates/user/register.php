<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
<<<<<<< HEAD
	<h1>Register</h1>


	<form method="POST" novalidate>
=======
	
	<form method="POST" class="form-horizontal" novalidate>
		
		<div class="form-group">	
			<label for="username" class="col-sm-2 control-label">Enter your username</label>
			<div class="col-sm-4">	
				<input type="text" class="form-control" name="username" placeholder="Enter your username">
			</div>
		</div>
		
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Enter your email</label>
			<div class="col-sm-4">
				<input type="email" class="form-control" name="email" placeholder="Enter your email">
			</div>
		</div>
>>>>>>> origin/master
		
		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Enter your password</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" name="password" placeholder="Enter your password">
			</div>
		</div>
		
		<div class="form-group">
			<label for="password_bis" class="col-sm-2 control-label">Confirm your password</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" name="password_bis" placeholder="Confirm your password">
			</div>
		</div>

		<?php echo $passwordError; ?><br />

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Register</button>
			</div>
		</div>

		</form>

<?php $this->stop('main_content') ?>
