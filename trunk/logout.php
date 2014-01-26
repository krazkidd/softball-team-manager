<?php
	session_start();

	require_once('common-definitions.php');

	if (isLoggedIn())
	{
		$_SESSION = array(); // or session_unset()
		session_destroy();
	}
	else
	{
		// user not logged in, redirect to Home page
		header('Location: index.php');
		exit(0);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Logout - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="logout-body">
		<div id="container">
			<div id="logout-header">
			      <h1>Logout</h1>
			</div>

<?php
	include('includes/navbar.php');
?>

			<div id="logout-content">
<?php
	if ( !isLoggedIn())
	{
?>
				<p>You were successfully logged out.<br />
<?php
	}
	else
	{
?>
//TODO this should never be seen. Show error message instead? (No, there's nothing the user can do to fix the error, so don't just show a message.)
				<p>You were not logged in. You are automatically being redirected to the home page.<br />
<?php
	}
?>
				   Click <a href="index.php">here</a> to go to the home page.</p>
			</div> <!-- logout-content -->

<?php
	include('includes/footer.php');
?>
		</div> <!-- end container -->
	</body>
</html>
