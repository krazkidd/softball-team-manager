<div id="roster">

<?php
//DEBUG
error_reporting(E_ALL);
ini_set('display_errors', 1);
//END DEBUG

function displayRoster()
{
	// create db connection
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs");
	// check for success
	if (mysqli_connect_errno($db_con))
	{
		echo "<p class=\"db-error\">Connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
		exit();
	}

	// display just about everything from the 'team' table
	$db_query_result = mysqli_query($db_con, "SELECT * FROM team");
	echo "<table><tr><th>Player Name</th><th>Number</th><th>Gender</th></tr>";
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

	// iterate through each row of the result, use a background color based on gender
	while ($row = mysqli_fetch_array($db_query_result))
	{
		$gender = $row['gender'];

                if ($gender == 'M')
			echo "<tr class=\"gender-male\">";
		else if ($gender == 'F')
			echo "<tr class=\"gender-female\">";
		else
			echo "<tr class=\"gender-missing\">";
//TODO need to encode player name as GET or POST data below
		echo "<td><a href=\"player-profile.php\">" . $row['name'] . "</a></td><td>" . $row['number'] . "</td><td>" . $row['gender'] . "</td></tr>";
	}
	echo "</table>";

//TODO Do I really *not* have to close the connection?
	mysqli_close($db_con);
}

?>

</div> <!-- roster -->
