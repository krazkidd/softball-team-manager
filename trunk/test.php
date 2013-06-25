<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="roster-body">
		<div id="roster-header">
		</div>

		<div id="roster">
<?php
//DEBUG
error_reporting(E_ALL);
ini_set('display_errors', 1);
//END DEBUG
	echo "<p>Teeeeext</p>";

	// create db connection
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs");
	// check for success
	if (mysqli_connect_errno($db_con))
	{
		echo "<p class=\"db-error\">Connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
		exit();
	}

	// get player names and numbers and show them in a table
	$db_query_result = mysqli_query($db_con, "SELECT * FROM team");
	echo "<table><tr><th>Player Name</th><th>Number</th><th>Gender</th></tr>";
//DEBUG
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG
	while ($row = mysqli_fetch_array($db_query_result))
	{
		$gender = $row['gender'];

                if ($gender == 'M')
			echo "<tr class=\"gender-male\">";
		else
			echo "<tr class=\"gender-female\">";
		echo "<td>" . $row['name'] . "</td><td>" . $row['number'] . "</td><td>" . $row['gender'] . "</td></tr>";
	}
	echo "</table>";

//TODO Do I really *not* have to close the connection?
	mysqli_close($db_con);
?>
		</div> <!-- lineup -->
  </body>
</html>
