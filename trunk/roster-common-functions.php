<?php
//DEBUG
error_reporting(E_ALL);
ini_set('display_errors', 1);
//END DEBUG

function displayRosterTable()
{
	// create db connection
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs");
	// check for success
	if (mysqli_connect_errno($db_con))
	{
		echo "<p class=\"db-error\">Connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
		exit();
	}

//DEBUG
//TODO fix query below and delete this
echo "<p>This only shows the roster of the Oddballs from Spring 2013 at Golf Links on Mondays.</p>";
//END DEBUG

//TODO is there a proper way to compare strings?
//TODO how to stop warning when 'orderby' is not in URL?
	if ($_GET['orderby'] == "name")
		$orderBy = "lastName";
	else
		$orderBy = "gender";

	$db_query_result = mysqli_query($db_con, "SELECT playerID, firstName, lastName, shirtNumber, gender FROM players INNER JOIN teams ON players.associatedTeam = teams.teamID WHERE teamID = 1 ORDER BY " . $orderBy);
$thisFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $thisFile);
$thisFile = $parts[count($parts) - 1];
	echo "<table><tr><th><a href=\"" . $thisFile . "?orderby=name\">Player Name</a></th><th>Number</th><th><a href=\"" . $thisFile . "?orderby=gender\">Gender</a></th></tr>";
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

	$total = 0;
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
		echo "<td><a href=\"player-profile.php?id=" . $row['playerID'] . "\">" . $row['firstName'] . " " . $row['lastName'] . "</a></td><td>" . $row['shirtNumber'] . "</td><td>" . $row['gender'] . "</td></tr>";

		$total++;
	}
	echo "</table>";

	echo "<p class=\"bold\">Total: " . $total . "</p>";

//TODO Do I really *not* have to close the connection?
	mysqli_close($db_con);
}

?>

