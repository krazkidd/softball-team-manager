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
	if (isset($_POST['btnLogIn']))
	{
		$_SESSION['loginname'] = 'LoggedInUser';
		header('Location: index.php');
		exit(0);
	}

	require_once('common-definitions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Login - Team Manager</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="login-body">
		<div id="container">
			<div id="login-header">
				<h1>Login</h1>
			</div> <!-- login-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="login-content">
				<p>Make sure cookies are enabled in your browser.</p>

				<form action="login.php" method="post">
					<div id="frmLogin">
						<label for="loginName">Login name:</label>
						<input type="text" nambe="loginName" id="loginName" /><br />

						<label for="password">Password:</label>
						<input type="password" nambe="password" id="password" /><br />

						<input type="submit" value="Log In" name="btnLogIn" />
						<p> or <a href="register.php" title="Register">Register</a></p>
					</div>
				</form>
			</div> <!-- login-content -->

<?php
	include('includes/footer.php');
?>
		</div> <!-- end container -->
	</body>
</html>
