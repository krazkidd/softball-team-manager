
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show some more info in title -->
	<title>Calendar</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
<?php
	require_once("common-definitions.php");
	require_once("calendar-common-functions.php");
?>
	</head>

	<body id="calendar-body">
		<div id="calendar-header">
			<h1>Calendar</h1>
		</div>

		<div id="calendar">
<?php
	$db_con = connectToDB();

//TODO by default, show everything for the logged-in user. but check GET or POST for a particular season/league/team(/game?)

//TODO so, do i want to use 'view' variable or 'date' (see next condition)
//     Well, this is for when the user clicks on the day of the week, so it needs to be kept
	if (isset($_GET['view']) && $_GET['view'] == 'daily' && isset($_GET['day']))
	{
//TODO delete this line below when this page is prettified
echo "<p class=\"error\">This still needs some work.</p>";
		// show leagues that play on selected day
		switch (substr(strtolower($_GET['day']), 0, 3))
		{
			case 'sun':
				$day = 'Sun';
				break;
			case 'mon':
				$day = 'Mon';
				break;
			case 'tue':
				$day = 'Tue';
				break;
			case 'wed':
				$day = 'Wed';
				break;
			case 'thu':
				$day = 'Thu';
				break;
			case 'fri':
				$day = 'Fri';
				break;
			case 'sat':
				$day = 'Sat';
				break;
			default:
				echo "<p>There was an error in your request. Click <a href=\"calendar.php\">here</a> to go to the Calendar page.</p>";
				echo "</div></body></html>";
				exit();
		}

		$db_query_result = mysqli_query($db_con, "SELECT * FROM leagues JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE leagues.dayOfWeek = '$day'");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

		// print a table that shows leagues that play on that day of the week
//TODO add a colspan to this table
		echo "<h2>$day Leagues</h2>";
//TODO add the table header columns. I got real lazy here
		echo "<table><tr><th>table header here</th></tr>";
		// iterate through each row of the result
		while ($row = mysqli_fetch_array($db_query_result))
		{
//TODO add a link to league info (i think i don't have a league info page yet)
//TODO add the other columns retrieved in query above. I'm REALLY lazy now.
			echo "<tr><td>{$row['division']}</td><td>{$row['class']}</td></tr>";
		}
		echo "</table>";
	}
	else if (isset($_GET['date']))
	{
//TODO make sure date argument is in proper format
		$db_game_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE date = '{$_GET['date']}' ORDER BY time");
//DEBUG
// show an error if the query failed
if ($db_game_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The game info query result was NULL :(</p>";
}
//END DEBUG

//DEBUG
echo "<p>{$_GET['date']}</p>"; 
//END DEBUG

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
			echo "<tr><td><a href=\"game-info.php?gameid={$row['gameID']}\">" . date("g\:i a", mktimeFromMySQLTime($row['time'])) . "</a></td><td>{$row[9]}</td><td>{$row[12]}</td>";

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
	{
//TODO check input for validity...month var must have leading zero, for example
		if (isset($_GET['month']))
		{
			$month = $_GET['month'];
			if (isset($_GET['year']))
				$year = $_GET['year'];
			else
				$year = date("Y");
		}
		else
		{
			$month = date("m");
			$year = date("Y");
		}

		displayCalendar($month, $year);
	}

	closeDB($db_con);
?>
		</div> <!-- calendar -->

	</body>
</html>
