<?php
	session_start();

	require_once("common-definitions.php");

	if (isLoggedIn())
	{
//TODO do some testing for how to correctly kill the session, because if the user still has a copy of the session id, the server may still remember the session
		$_SESSION = array(); // or session_unset()
		session_destroy();
	}
	else
	{
//TODO if i don't want a time delay, and I *do* for mobile users, put a message on the home screen about the last action--successful or not
		header("Location: index.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<title>Logout</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="logout-body">

		<div id="logout-header">
		      <h1>Logout</h1>
		</div>
      
		<div id="logout-content">
<?php
	if (!isLoggedIn())
	{
?>
			<p>You were successfully logged out.<br>
<?php
	}
	else
	{
?>
			<p>You were not logged in. You are automatically being redirected to the home page.<br>
<?php
	}
?>
			Click <a href="index.php">here</a> to go to the home page.</p>
		</div> <!-- logout-content -->

	</body>
</html>
