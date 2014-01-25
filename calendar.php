<?php
	session_start();
	require_once('common-definitions.php');
	require_once('calendar-common-functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show some more info in title -->
	<title>Calendar</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="calendar-body">
		<div id="calendar-header">
			<h1>Calendar</h1>
		</div>

		<div id="calendar">
<?php
	$db_con = connectToDB();

//TODO by default, show everything for the logged-in user. but check GET or POST for a particular season/league/team(/game?)
//make an array of the leagues for the current user
/*
	// show all leagues that play on a certain day of the week when the user clicks on the day header
	if (isset($_GET['view']) && $_GET['view'] == 'daily' && isset($_GET['day']))
	{
		// show leagues that play on selected day
		switch (strtolower(substr($_GET['day'], 0, 3)))
		{
			case 'sun':
			case 'mon':
			case 'tue':
			case 'wed':
			case 'thu':
			case 'fri':
			case 'sat':
				$day = ucwords(strtolower(substr($_GET['day'], 0, 3)));
				break;
			default:
?>
			<p>There was an error in your request. Click <a href="calendar.php">here</a> to go to the default Calendar page.</p>
		</div>

	</body>
</html>
<?php
				exit();
		}

		$db_query_result = mysqli_query($db_con, "SELECT * FROM leagues JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE leagues.dayOfWeek = '$day' ORDER BY startDate DESC");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

		// print a table that shows leagues that play on that day of the week
//TODO add the table header columns below. I got real lazy here
//TODO add a colspan to this table
?>
			<h2><?= $day ?> Leagues</h2>

			<table>
				<tr>
					<th>Division</th>
					<th>Class</th>
					<th>Description</th>
				</tr>
<?php
		// iterate through each row of the result
		while ($row = mysqli_fetch_array($db_query_result))
		{
//TODO add a link to league info (i think i don't have a league info page yet)
//TODO add the other columns retrieved in query above.
?>
				<tr>
					<td><?= $row['division'] ?></td>
					<td><?= $row['class'] ?></td>
					<td><?= $row['description'] ?></td>
				</tr>
<?php
		}
?>
			</table>
<?php
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

?>
			<h3><?= $_GET['date'] ?></h3> 
			<div id="game-list"> <!-- TODO I think i would like a better ID for this div, and i would especially like to merge it's style with the case where a game ID is present -->
			<table>
				<tr>
					<th>Time</th>
					<th>Home Team</th>
					<th>Visiting Team</th>
<?php
		$row = mysqli_fetch_array($db_game_info_query_result);
		// if date/time of first game + 1 hour is passed, show result columns
//TODO i guess there might be a problem comparing time and mktime values. see gmmktime doc page
		$showResults = false;
		if (time() > mktime(getHourFromMySQLTime($row['time']) + 1, getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date'])))
		{
?>
					<th>Final Home Score</th>
					<th>Final Visiting Score</th>
<?php
			$showResults = true;
		}
?>
				</tr>
<?php
		do
		{
			// get team names
			$homeTeamRow = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM teams WHERE teamID = {$row['homeTeam']}"));
			$awayTeamRow = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM teams WHERE teamID = {$row['visitingTeam']}"));
?>
				<tr>
					<td><a href="game-info.php?gameid=<?= $row['gameID'] ?>"><?= date("g\:i a", mktimeFromMySQLTime($row['time'])) ?></a></td>
					<td><?= $homeTeamRow["name"] ?></td>
					<td><?= $awayTeamRow["name"] ?></td>
<?php
			if ($showResults)
			{
				$finalHome = $row['finalHomeScore'];
				$finalAway = $row['finalVisitingScore'];
//TODO check to see if the scores are NULL and output something appropriate (I show the score columns before all games have finished)
?>
					<td><?= $finalHome ?> <?= $finalHome > $finalAway ? "<img alt=\"Winner\" src=\"icons/1373708645_trophy.png\" />" : "" ?></td>
					<td><?= $finalAway ?> <?= $finalAway > $finalHome ? "<img alt=\"Winner\" src=\"icons/1373708645_trophy.png\" />" : "" ?></td>
<?php
			}
?>
				</tr>
<?php
		}  while ($row = mysqli_fetch_array($db_game_info_query_result));
?>
			</table>
		</div> <!-- game-list -->
<?php
	}
	else
	{*/
		if (isset($_GET['mo']))
		{
			$month = $_GET['mo'];
			if (isset($_GET['yr']))
				$year = $_GET['yr'];
			else
				$year = date('Y');
		}
		else
		{
			$month = date('m');
			$year = date('Y');
		}

		displayCalendar((int)$month, (int)$year);
	//}

	closeDB($db_con);
?>
		</div> <!-- calendar -->

	</body>
</html>
