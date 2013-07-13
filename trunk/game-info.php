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
		<div id="game-info-header">
			<h1>Game Info</h1>
		</div>

		<p><a href="field-layout.php">View Field Layout &gt; &gt;</a></p>
<?php
//TODO check GET or POST for a game ID. if nothing, redirect to calendar? or just show a table? or pick next game?

	// create db connection
//TODO don't use die()
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs") or die(mysqli_error());

	if (isset($_GET['date']))
	{
//TODO parse date from URL
	}
	else
	{


ERROR this page should only take a game ID, not a date. Dates should go to calendar page


//TODO pick better default date. 
		$date = mktime(0, 0, 0, 3, 25, 2013);
	}

	// check if a whole night is requested or just a single game
//TODO to be more robust, i should prioritize gameid over date, i.e. ignore date if gameid is present
	if (isset($_GET['gameid']))
	{
		$db_game_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE gameID = {$_GET['gameid']}");
		$db_team_info_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN games ON games.homeTeam = teams.teamID OR games.visitingTeam = teams.teamID");
//DEBUG
// show an error if either of the queries failed
if ($db_game_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The game info result was NULL :(</p>";
}
if ($db_team_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The team info result was NULL :(</p>";
}
//END DEBUG

//TODO PRINT TABLE? no, it's only one row. try doing two columns with more data like Record (W-L)
//TODO print home and visiting team info
		echo "<div class=\"home-team\"></div>";
		
		echo "<div class=\"visiting-team\"></div>";
	}
	else if (isset($date))
	{
		// this is not the same game info query as above, since this grabs all games for a single date
		$db_game_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE date = '" . date("Y-m-d", $date) . "' ORDER BY time");
//DEBUG
// show an error if the query failed
if ($db_game_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The game info query result was NULL :(</p>";
}
//END DEBUG

//DEBUG
echo "<p>" . date("Y-m-d", $date) . "</p>"; 
//END DEBUG

//TODO move these definition somewhere else
function getHourFromMySQLTime($timeString)
{
	return substr($timeString, 0, 2);
}
function getMinuteFromMySQLTime($timeString)
{
	return substr($timeString, 3, 2);
}
function getYearFromMySQLDate($dateString)
{
	return substr($dateString, 0, 4);
}
function getMonthFromMySQLDate($dateString)
{
	return substr($dateString, 5, 2);
}
function getDayFromMySQLDate($dateString)
{
	return substr($dateString, 8, 2);
}

//TODO add second parameter for date?
function mktimeFromMySQLTime($timeString)
{
	return mktime(getHourFromMySQLTime($timeString), getMinuteFromMySQLTime($timeString));
}

//TODO I think i would like a better ID for this div, and i would especially like to merge it's style with the case where a game ID is present
		echo "<div id=\"game-list\">";
		echo "<table><tr><th>Time</th><th>Home Team</th><th>Visiting Team</th>";
		$row = mysqli_fetch_array($db_game_info_query_result);
		// if date/time of first game + 1 hour is passed, show result columns
//TODO i guess there might be a problem comparing time and mktime values. see gmmktime doc page
		$showResults = false;
		if (time() > mktime(getHourFromMySQLTime($row['time']) + 1, getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date'])))
		{
			echo "<th>Final Home Score</th><th>Final Visiting Score</th>";
			$showResults = true;
		}

		echo "</tr>";

		do
		{
			$thisFile = $_SERVER["PHP_SELF"];
			$parts = Explode('/', $thisFile);
			$thisFile = $parts[count($parts) - 1];
//TODO make every row element a link?
//TODO this isn't working. right now, i can get the team names from the one query but i have to use a numerical index, which can change... Either fix the original query to fix that,
// or fix pulling the team names from the teams table
			// get team names
			//$tmpArray = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM teams WHERE teamID = {$row['homeTeam']}"));
			//$homeTeam = $tmpArray['homeTeam'];
			//$visitingTeam = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM teams WHERE teamID = {$row['visitingTeam']}"))['visitingTeam'];
			echo "<tr><td><a href=\"" . $thisFile . "?gameid={$row['gameID']}\">" . date("g\:i a", mktimeFromMySQLTime($row['time'])) . "</a></td><td>{$row[9]}</td><td>{$row[12]}</td>";

			if ($showResults)
			{
				$finalHome = $row['finalHomeScore'];
				$finalAway = $row['finalVisitingScore'];
//TODO check to see if the scores are NULL and output something appropriate (I show the score columns before all games have finished)
				echo "<td>{$finalHome}" . ($finalHome > $finalAway ? "&nbsp;<img alt=\"Winner\" src=\"icons/1373708645_trophy.png\" />" : "") . "</td><td>{$finalAway}" . ($finalAway > $finalHome ? "&nbsp;<img alt=\"Winner\" src=\"icons/1373708645_trophy.png\" />" : "") . "</td>";
			}
			echo "</tr>";
		}  while ($row = mysqli_fetch_array($db_game_info_query_result));

		echo "</table>";
		echo "</div> <!-- game-list -->";
	}
	else
//TODO don't use die(), and close the db if needed
		die("I need a gameid.");

//TODO Do I really *not* have to close the connection?
	mysqli_close($db_con);

?>

	</body>
</html>
