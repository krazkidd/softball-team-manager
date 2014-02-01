<?php $title = 'Login' ?>

<?php ob_start() ?>
	
<?php if ($action == 'login-success') { ?>
	<p class='success-msg'>You were successfully logged in!</p>
<?php }	else { // show login form ?>
	<p>This website uses cookies to keep track of your session.</p>

	<form action="login.php" method="post">
		<div id="frmLogin">
			<label for="loginName">Login name:</label>
			<input type="text" name="loginName" id="loginName" value="<?php echo $failedLoginName ?>"/><br />

			<label for="password">Password:</label>
			<input type="password" name="password" id="password" /><br />

			<input type="submit" value="Log In" name="btnLogIn" />
		</div>
	</form>

	<?php if ($action == 'login-fail') { ?>
		<p class='fail-msg'>Login failed!</p>
	<?php } ?>

	<p>or <a href="register.php" title="Register">Register</a></p>
<?php } ?>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
