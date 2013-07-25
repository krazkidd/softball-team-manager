<?php
	session_start();
	require_once("common-definitions.php");
	require_once("calendar-common-functions.php");

	if (!isLoggedIn())
	{
		header("Location: index.php");
//TODO is exit() okay here? Anyway, an error message should be shown to the user.
//TODO user must have permissions to view their lineup
		exit();
	}

	$db_con = connectToDB();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show game info in title -->
		<title>Lineup</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="lineup-body">

		<div id="lineup-header">
			<h1>Lineup</h1>
		</div>
<?php
	if (!isset($_GET["gameid"]))
	{
		$db_next_games_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN leagues ON games.associatedLeague = leagues.leagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE seasons.seasonID = " . getUserSeasonID() . " WHERE games.date >= CURDATE() ORDER BY games.date LIMIT 6");

		if ($db_next_games_query_result == NULL)
		{
?>
		<p>I need a game ID. Try using the <a href="calendar.php">Calendar</a>.</p>
<?php
		}
		else
		{
?>
		<p>I need a game ID. Try using the <a href="calendar.php">Calendar</a> or one of the following games in your default season:</p>
		<ul>
<?php
			$thisFile = $_SERVER["PHP_SELF"];
			$parts = Explode('/', $thisFile);
			$thisFile = $parts[count($parts) - 1];

			while ($row = mysqli_fetch_array($db_next_games_query_result))
			{
				$gameTime = mktime(getHourFromMySQLTime($row['time']), getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date']));
?>
			<li><a href="<?= $thisFile ?>?gameid=<?= $row["gameID"] ?>"><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></a></li>
<?php
			}
		}
?>
		</ul>

	</body>
</html>
<?php
		closeDB();
		exit();
	}

//TODO it's possible to have *2* lineups. so obviously you need to be querying the user's team id too
	$lineupPlayerIDs = mysqli_fetch_array(mysqli_query($db_con, "SELECT pos1, pos2, pos3, pos4, pos5, pos6, pos7, pos8, pos9, pos10, EP1, EP2, EP3, EP4, EP5 FROM lineups WHERE associatedGame = {$_GET["gameid"]}"));
//TODO this returns double results...or implode() double-prints...
	$lineupBatPos = mysqli_fetch_array(mysqli_query($db_con, "SELECT batPos1, batPos2, batPos3, batPos4, batPos5, batPos6, batPos7, batPos8, batPos9, batPos10, batPosEP1, batPosEP2 FROM lineups WHERE associatedGame = {$_GET["gameid"]}"));
	$gameInfo = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM games WHERE gameID = {$_GET["gameid"]}"));
//DEBUG
// show an error if the query failed
if ($lineupPlayerIDs == NULL)
  echo "<p class=\"db-error\">The lineup result was NULL :(</p>";
//END DEBUG

//TODO this seems to be getting double results. i wonder why.
	$db_player_query_result = mysqli_query($db_con, "SELECT playerID, firstName, lastName, shirtNumber, gender FROM players WHERE playerID IN (" . implode(", ", array_filter($lineupPlayerIDs)) . ")");
	// put the players returned from the query in an Array, indexed by their player ID
	$players = Array();
	while ($row = mysqli_fetch_array($db_player_query_result))
	{
		$players[$row["playerID"]] = $row;
	}

//TODO need to check that a player's batting order number isn't NULL if they have a position, as well as several other things i have written on paper
//ERROR keep track of starters/non-starters instead of doing all this weird condition checking. batPos will be NULL for non-starters (and obviously, for EP{3,4,5}, batPos doesnt exist). 
//how am i storing ep1/ep2 in the db? numbers 11 & 12? these two need to be treated specially everywhere. if the team is co-ed and these two are male-female, put them in the batting order. otherwise they go down below
//ERROR check for NULL!! EPs and 1 of the fielders can be null. if more than 1, forfeit/error!
function convertNumberedFieldPositionToAlpha($pos)
{
	switch ($pos)
	{
		case 1:
			return "P";
		case 2:
			return "C";
		case 3:
			return "1B";
		case 4:
			return "2B";
		case 5:
			return "3B";
		case 6:
			return "SS";
		case 7:
			return "LF";
		case 8:
			return "CF";
		case 9:
			return "RF";
		case 10:
			return "RC";
//TODO do i want to use cases 11 and 12 for EP1 and EP2?
		default:
			return "Invalid Position";
	}
}

	$starters = Array();
	$nonstarters = Array();

	for ($i = 1; $i < 10; $i++)
	{
		if ($lineupPlayerIDs["pos$i"])
		{
			$starters[$lineupBatPos["batPos$i"]] = $players[$lineupPlayerIDs["pos$i"]];
			// tack on the alphabetic position initials
//TODO okay, problem: the positions change depending on number of players. CF is synonomous with LC and Rover with RC, but I need to do this in a way that's not confusing for the user
//* maybe show "LC (CF)" while the number of players is not known, and either "LC" or "CF" when it is
			$starters[$lineupBatPos["batPos$i"]]["position"] = convertNumberedFieldPositionToAlpha($i);
		}
	}

	// check the extra players. if there is an extra male and female, they belong in the starting lineup
//TODO do some more checking, like for gender. set a note to check that extra players are put into the database correctly
	if ($lineupPlayerIDs["EP1"] && $lineupBatPos["batPosEP1"])
	{
		$starters[$lineupBatPos["batPosEP1"]] = $players[$lineupPlayerIDs["EP1"]];
		$starters[$lineupBatPos["batPosEP1"]]["position"] = "EP1";
	}
	else if ($lineupPlayerIDs["EP1"])
		$nonstarters["EP1"] = $players[$lineupPlayerIDs["EP1"]];

	if ($lineupPlayerIDs["EP2"] && $lineupBatPos["batPosEP2"])
	{
		$starters[$lineupBatPos["batPosEP2"]] = $players[$lineupPlayerIDs["EP2"]];
		$starters[$lineupBatPos["batPosEP2"]]["position"] = "EP2";
	}
	else if ($lineupPlayerIDs["EP2"])
		$nonstarters["EP2"] = $players[$lineupPlayerIDs["EP2"]];

	if ($lineupPlayerIDs["EP3"])
		$nonstarters["EP3"] = $players[$lineupPlayerIDs["EP3"]];
	if ($lineupPlayerIDs["EP4"])
		$nonstarters["EP4"] = $players[$lineupPlayerIDs["EP4"]];
	if ($lineupPlayerIDs["EP5"])
		$nonstarters["EP5"] = $players[$lineupPlayerIDs["EP5"]];

	closeDB($db_con);

	$gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date']));
?>

		<h3><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></h3>

		<div id="lineup-whole-form">
			<p>Team TODO</p>
			<p>League TODO</p>
			<p>Coach/Manager TODO</p>

			<div id="batting-order">
				<table>
					<tr>
						<th colspan="4">Starting Lineup</th>
					</tr>
					<tr>
						<td>No.</td>
						<td>First &amp; Last Name</td>
						<td>Pos.</td>
						<td>Sub. #</td>
					</tr>

<?php
//TODO check for alternating gender
	for ($i = 1; $i <= count($starters); $i++)
	{
//TODO is there anything wrong with being a little wanton with NULL?
//TODO I probably want to show gender as well, so I'm really going to need a way to loop either through the IDs or the positions and record everything in a big array
//TODO the style I have now should be the print style. i should make the default style easier to interact with, like when I add Javascript later
?>
					<tr>
						<td><?= $starters[$i]["shirtNumber"] ?></td>
						<td><?= $starters[$i]["firstName"] . " " . $starters[$i]["lastName"] ?></td>
						<td><?= $starters[$i]["position"] ?></td>
						<td>&nbsp;</td>
					</tr>
<?php
	}

	for ($i = count($starters) + 1; $i <= 12; $i++)
	{
?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
<?php
	}
?>

					<tr>
						<th colspan="4">Non-Starters</th>
					</tr>
					<tr>
						<td>No.</td>
						<td colspan="3">First &amp; Last Name</td>
					</tr>

<?php
	for ($i = 1; $i <= count($nonstarters); $i++)
	{
?>
					<tr>
						<td><?= $nonstarters["EP$i"]["shirtNumber"] ?></td>
						<td colspan="3"><?= $nonstarters["EP$i"]["firstName"] . " " . $nonstarters["EP$i"]["lastName"] ?></td>
					</tr>
<?php
	}
	
//TODO add EP6 to DB and to query above
	for ($i = count($nonstarters) + 1; $i <= 6; $i++)
	{
?>
					<tr>
						<td>&nbsp;</td>
						<td colspan="3">&nbsp;</td>
					</tr>
<?php
	}
?>
				</table>
			</div> <!-- lineup-whole-form -->

		</div>

		<p>View the graphical Field Layout page <a href="field-layout.php?gameid=<?= $_GET["gameid"] ?>">here</a>.</p>

	</body>
</html>

