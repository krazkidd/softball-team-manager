<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Edit Roster</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="edit-roster-body">
		<div id="edit-roster-header">
			<h1>Edit Roster</h1>
		</div>

<?php

	if (!empty($_POST['edit']))
	{
		// I don't need to do anything here, really
	}
	else if (!empty($_POST['addplayer']))
	{
//TODO sanitize user input!!!
		// the user has put a name into the field and pressed the 'Add' button. Try adding to the db
		// connect to the db
		$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs");
		// check for success
		if (mysqli_connect_errno($db_con))
		{
			echo "<p class=\"db-error\">Connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
			exit();
		}

		// add the new player
		$db_query_result = mysqli_query($db_con, "INSERT INTO team (name, number, gender) VALUES (\"" . $_POST['playerName'] . "\", NULL, NULL)");
//DEBUG
/*if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
else
{
	echo "<p>Add player success?<br />\$db_query_result = " . $db_query_result . "</p>";
}*/
//END DEBUG

		mysqli_close($db_con);
	}
	else if (!empty($_POST['removeplayer']))
	{
		// show form to remove player
//TODO Do I want radio buttons next to names above? If so, can I put those buttons in a separate <form> block? Otherwise, show drop-down box.
		echo "<p>Remove player not implemented yet.</p>";
	}
	else
	{
		// there was an error processing the request. Return to previous page.
//TODO
		echo "<p class=\"error\">There was an error. I don't know what action I'm supposed to do!";
	}

?>

		<div id="roster">
<?php

	require_once("roster-common-functions.php");

	displayRosterTable();

?>
		</div> <!-- roster -->

		<div id="form-add-player">
<!-- //TODO labels for input fields! -->
			<form action="edit-roster.php" method="post">
				<input type="input" name="playerName" />
<!-- //TODO use btnName or nameBtn for form elements (in given case, a button) -->
				<input type="submit" name="addplayer" value="Add this player to my roster" />
			</form>
		</div> <!-- form-addplayer -->
	</body>
</html>
