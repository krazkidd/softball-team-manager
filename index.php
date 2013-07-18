<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<title>Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
<?php
	require_once("common-definitions.php");
?>
	</head>

	<body id="index-body">

		<div id="index-header">
		      <h1>Team Manager</h1>
		</div>
      
		<div id="index-content">
<?php
	if (isLoggedIn())
	{
?>
			<p><a href="roster.php">Go to Roster &gt; &gt;</a><br>
			<a href="calendar.php">Go to Calendar &gt; &gt;</a></p>
<?php
	}
	else
	{
//TODO I can still start a session for a not-logged in user. They should be able to see games, but not players
?>
			<p>You are not logged in.
			<a href="calendar.php">Go to Calendar &gt; &gt;</a></p>
<?php
	}
?>
		</div>
<?

<?php
	include("login-module.php");
?>

		<div id="index-footer">
			<p><a href="index.php">Home</a></p>
		</div>

	</body>
</html>
