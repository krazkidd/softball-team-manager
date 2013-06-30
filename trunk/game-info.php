<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show game info in title -->
	<title>Game Info</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="game-info-body">
		<div id="roster-header">
			<h1>Roster</h1>
		</div>

		<div id="roster">
<?php
	require("roster-common-functions.php");

	displayRosterTable();
?>
		</div> <!-- roster -->

		<div id="form-edit-roster">
			<form action="edit-roster.php" method="post">
				<!-- <input type="submit" name="addplayer" value="Add Player" />
				<input type="submit" name="removeplayer" value="Remove Player" /> -->
				<input type="submit" name="edit" value="Edit Roster" />
			</form>
		</div> <!-- form-edit-roster -->
		<!-- <div>
			<p><a href="edit-roster.php">Edit Roster</a></p>
		</div> -->
	</body>
</html>
