<?php
	session_start();

//TODO need user table in db..........
//TODO in case the user did something while not logged in, try to save as much of their session as is reasonable

	/*if (isset($_SESSION["username"]))
	{
//TODO set a flag so we can tell user they are logged in already
	}*/
//TODO should this if be elseif or what?
	if (isset($_POST["btnLogIn"]))
	{
		$_SESSION["username"] = "LoggedInUser";
		header("Location: index.php");

	}
	else
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Login</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
<?php
	require_once("common-definitions.php");
?>
	</head>

	<body id="login-body">
		<div id="login-header">
			<h1>Login</h1>
		</div> <!-- login-header -->

		<div id="login-content">
			<p>Make sure cookies are enabled in your browser.</p>
			<form action="login.php" method="post">
				<input type="submit" value="Log In" name="btnLogIn">
			</form>
		</div> <!-- login-content -->
	</body>
</html>
<?php
	}
?>
