<?php

  /**************************************************************************

  This file is part of Team Manager.

  Copyright © 2013 Mark Ross <krazkidd@gmail.com>

  Team Manager is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  Team Manager is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with Team Manager.  If not, see <http://www.gnu.org/licenses/>.
  
  **************************************************************************/

require_once '../models/model.php';

function getRoster($teamID)
{
//TODO validate!
//TODO need season/league parameters! (and fix query below)
	//$roster_query_result = runQuery('SELECT DISTINCT TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription FROM Roster WHERE TeamName = \'' . $escapedTeamName . '\' ORDER BY SeasonDescription');
	$roster_query_result = runQuery('SELECT PlayerID, ShirtNum, Disabled, FirstName, LastName, NickName, Gender FROM Roster AS R JOIN Player AS P ON R.PlayerID = P.ID WHERE TeamID = ' . $teamID . ' ORDER BY ShirtNum');

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

	return $result;
}

/*ERROR this function cannot work with just a team ID.
also, I'm not sure about this idea of printing (tables)
from a function TODO DON'T PRINT, YA DINGUS*/
function displayRosterTable($teamID)
{
	// show team info
	$db_team_info_query_result = runQuery("SELECT * FROM teams JOIN leagues ON teams.associatedLeague = leagues.leagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE teams.teamID = $teamID");
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
			echo "<tr class=\"gender-undeclared\">";
//TODO need to encode player name as GET or POST data below
		echo "<td><a href=\"/player/" . $playerRow['playerID'] . "\">" . $playerRow['firstName'] . " " . $playerRow['lastName'] . "</a></td><td>" . $playerRow['shirtNumber'] . "</td><td>" . $playerRow['gender'] . "</td></tr>";

		$total++;
	}
	echo "</table>";

	echo "<p class=\"bold\">Total: " . $total . "</p>";
}
