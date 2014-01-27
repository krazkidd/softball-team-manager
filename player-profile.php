<?php
	session_start();
	require_once('common-definitions.php');

	if (!isLoggedIn())
	{
		header('Location: index.php');
		quit(0);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Player Profile - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
<?php
	require_once('player-common-functions.php');
?>
	</head>

	<body id="player-profile-body">
		<div id="container">
			<div id="player-profile-header">
				<h1>Player Profile</h1>
			</div> <!-- player-profile-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="player-profile-content">
<?php

	displayPlayerInfo($_GET['id']);


	include('includes/footer.php');
?>
			</div> <!-- player-profile-content -->
		</div> <!-- end container -->
	</body>
</html>
