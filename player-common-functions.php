<?php

require_once("common-definitions.php");

function displayPlayerInfo($playerID)
{
	$db_con = connectToDB();

	$db_query_result = mysqli_query($db_con, "SELECT firstName, lastName, phoneNumber, emailAddress, shirtNumber, gender FROM players WHERE players.playerID = $playerID");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

	$playerInfo = mysqli_fetch_array($db_query_result);

	echo "<img title=\"" . $playerInfo['firstName'] . " " . $playerInfo['lastName'] . "\" src=\"images/player-no-image.gif\" />";
	echo "<h2 id=\"player-name-header\">" . $playerInfo['firstName'] . " " . $playerInfo['lastName'] . "</h2>";
	echo "<h3>#" . $playerInfo['shirtNumber'] . "</h3>";
	echo "<p><span class=\"bold\">Phone:</span> " . $playerInfo['phoneNumber'] . "<br />";
	echo "<span class=\"bold\">Email:</span> " . $playerInfo['emailAddress'] . "<br />";
	echo "<span class=\"bold\">Gender:</span> " . $playerInfo['gender'] . "</p>";

	// print current/most recent teams in a table
	echo "<div id=\"player_s-teams\">";
	// get today's date	
	//$today = date("Y-m-d");
	// find all rows for the player in the players table. Players are duplicated as seasons pass; that's why this query is ugly.
//TODO need a better way to find the player. Now, we are only checking first and last name. That is not unique enough. Is it okay to keep driver's license #? How about just a hash?
	$db_query_result = mysqli_query($db_con, "SELECT * FROM players AS p1 JOIN players AS p2 ON p1.firstName = p2.firstName AND p1.lastName = p2.lastName JOIN teams ON p2.associatedTeam = teams.teamID JOIN leagues ON teams.associatedLeague = leagues.leagueID JOIN seasons ON leagues.associatedSeason = seasonID WHERE p1.playerID = " . $playerID);
	$tableHeaderMustBePrinted = true;
	while ($row = mysqli_fetch_array($db_query_result))
	{
//TODO it might be best if I just have a global variable for the current/next season
//Previously, I wanted to have a function to find the latest season the player was playing in. I can still do that.
		if ($row['seasonID'] == 1)
		{
			if ($tableHeaderMustBePrinted)
			{
				$tableHeaderMustBePrinted = false;		
				echo "<p class=\"bold\">Currently playing in these divsions:</p>";
				echo "<table><tr><th>Season</th><th>Division</th><th>Class</th><th>Park</th><th>Team</th></tr>";
			}

//TODO needs a day-of-week column
			echo "<tr><td class=\"spring13\">" . $row['description'] . "</td><td>" . $row['division'] . "</td><td>" . $row['class'] . "</td><td>" . $row['park'] . "</td><td>" . $row['name'] . "</td></tr>";
		}
	}

	// only close table if needed
	if ( !$tableHeaderMustBePrinted)
		echo "</table>";

	echo "</div> <!-- player_s-teams -->";

	closeDB($db_con);
}

?>
