<?php
	session_start();

//TODO need user table in db..........
//TODO in case the user did something while not logged in, try to save as much of their session as is reasonable

	if (isset($_SESSION['loginname']))
	{
		// user is already logged in
		header('Location: index.php');
		exit(0);
	}
	if (isset($_POST['btnRegister']))
	{
		$_SESSION['loginname'] = 'LoggedInUser';
//TODO what to do after successful login? Redirect or show message?
	}

	require_once('common-definitions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Register - Team Manager</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="register-body">
		<div id="container">
			<div id="register-header">
				<h1>Register</h1>
			</div> <!-- register-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="register-content">
				<p>Make sure cookies are enabled in your browser.</p>

				<form action="register.php" method="post">
					<div id="frmLogin">
						<label for="loginName">Login name:</label>
						<input type="text" nambe="loginName" id="loginName" /><br />

						<label for="password1">Password:</label>
						<input type="password" nambe="password1" id="password1" /><br />

						<label for="password2">Re-enter password:</label>
						<input type="password" nambe="password2" id="password2" /><br />

						<input type="submit" value="Register" name="btnRegister" />
					</div>
				</form>
			</div> <!-- login-content -->

<?php
	include('includes/footer.php');
?>
		</div> <!-- end container -->
	</body>
</html>
