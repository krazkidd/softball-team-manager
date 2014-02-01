<?php

require_once 'models/model.php';

function getRoster($teamName)
{
//TODO validate!
//TODO need season/league parameters! (and fix query below)
	$db_con = connectToDB();
	$escapedTeamName = mysqli_real_escape_string($db_con, $teamName);

	//$roster_query_result = mysqli_query($db_con, 'SELECT DISTINCT TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription FROM Roster WHERE TeamName = \'' . $escapedTeamName . '\' ORDER BY SeasonDescription');
	$roster_query_result = mysqli_query($db_con, 'SELECT ShirtNum, Notes, Disabled, FirstName, LastName, NickName, Gender FROM Roster AS R JOIN Player AS P ON R.PlayerID = P.ID WHERE TeamName = \'' . $escapedTeamName . '\' ORDER BY ShirtNum');

	if ( !$roster_query_result)
	{
		error_log("Roster query result was NULL");
		return NULL;
	}

	$result = array();
	while ($row = mysqli_fetch_array($roster_query_result))
	{
		$result[] = $row;
	}

	closeDB($db_con);
	return $result;
}

/*ERROR this function cannot work with just a team ID.
also, I'm not sure about this idea of printing (tables)
from a function*/
function displayRosterTable($teamID)
{
	$db_con = connectToDB();

	// show team info
	$db_team_info_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN leagues ON teams.associatedLeague = leagues.leagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE teams.teamID = $teamID");
	$gameInfo = mysqli_fetch_array($db_team_info_query_result);
?>
	<h3><?= $gameInfo["name"] ?></h3>
	<p><?= $gameInfo["description"] ?><br>
	<?= $gameInfo["division"] . " " . $gameInfo["class"] . " @ " . $gameInfo["park"] . " #" . $gameInfo["field"] . " on " . $gameInfo["dayOfWeek"] ?></p>
<?php
//TODO is there a proper way to compare strings? == vs. === vs. strcmp()
	if (isset($_GET['orderby']) && $_GET['orderby'] == "name")
		$orderBy = "lastName";
	else
		$orderBy = "gender, lastName";

	$db_roster_query_result = mysqli_query($db_con, "SELECT playerID, firstName, lastName, shirtNumber, gender FROM players INNER JOIN teams ON players.associatedTeam = teams.teamID WHERE teamID = $teamID ORDER BY " . $orderBy);

	/*$thisFile = $_SERVER["PHP_SELF"];
	$parts = Explode('/', $thisFile);
	$thisFile = $parts[count($parts) - 1];
	echo "<table><tr><th><a href=\"" . $thisFile . "?orderby=name\">Player Name</a></th><th>Number</th><th><a href=\"" . $thisFile . "?orderby=gender\">Gender</a></th></tr>";*/
	echo "<table><tr><th>Player Name</th><th>Number</th><th>Gender</th></tr>";
//DEBUG
if ( !$db_roster_query_result)
error_log('The roster result was NULL');
//END DEBUG

	$total = 0;
	// iterate through each row of the result, use a background color based on gender
	while ($playerRow = mysqli_fetch_array($db_roster_query_result))
	{
		$gender = $playerRow['gender'];

		if ($gender == 'M')
			echo "<tr class=\"gender-male\">";
		else if ($gender == 'F')
			echo "<tr class=\"gender-female\">";
		else
			echo "<tr class=\"gender-missing\">";
//TODO need to encode player name as GET or POST data below
		echo "<td><a href=\"player-profile.php?id=" . $playerRow['playerID'] . "\">" . $playerRow['firstName'] . " " . $playerRow['lastName'] . "</a></td><td>" . $playerRow['shirtNumber'] . "</td><td>" . $playerRow['gender'] . "</td></tr>";

		$total++;
	}
	echo "</table>";

	echo "<p class=\"bold\">Total: " . $total . "</p>";

	closeDB($db_con);
}
