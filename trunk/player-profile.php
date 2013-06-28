<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Player Profile</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="player-profile-body">
		<div id="player-profile-header">
			<h1>Player Profile</h1>
		</div>

		<div id="player-profile-content">
<?php
	require("player-common-functions.php");
	displayPlayerInfo($_GET['id']);
?>
		</div>
	</div> <!-- body -->
  </body>
</html>
