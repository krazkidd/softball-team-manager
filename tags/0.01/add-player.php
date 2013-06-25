THIS IS NOT BEING USED.

<?php
	// create db connection
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs");
	// check for success
	if (mysqli_connect_errno($db_con))
	{
//TODO this file isn't supposed to return HTML, so I need a different way of communicating this error
		echo "<p class=\"db-error\">Connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
		exit();
	}

	// get player names and numbers and show them in a table
//TODO user input needs to be sanitized
	$db_query_result = mysqli_query($db_con, "INSERT ");
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
