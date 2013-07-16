<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show game info in title -->
	<title>Game Info</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
<?php
	require_once("common-functions.php");
	require_once("calendar-common-functions.php");
?>
	</head>

	<body id="game-info-body">
		<div id="game-info-header">
			<h1>Game Info</h1>
		</div>

<!--		<p><a href="field-layout.php">View Field Layout &gt; &gt;</a></p> -->
<?php
//TODO check GET or POST for a game ID. if nothing, redirect to calendar? or just show a table? or pick next game?

	$db_con = connectToDB();

	// check if a whole night is requested or just a single game
//TODO to be more robust, i should prioritize gameid over date, i.e. ignore date if gameid is present
	if (isset($_GET['gameid']))
	{
		$db_game_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN leagues ON leagues.leagueID = games.associatedLeague JOIN seasons ON seasons.seasonID = leagues.associatedSeason JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE gameID = {$_GET['gameid']}");
		$db_team_info_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN games ON games.homeTeam = teams.teamID OR games.visitingTeam = teams.teamID WHERE gameID = {$_GET['gameid']}");
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
		$gameInfo = mysqli_fetch_array($db_game_info_query_result);
		$homeTeamInfo = mysqli_fetch_array($db_team_info_query_result);
		// make sure I really got the home team
		if ($homeTeamInfo['teamID'] != $gameInfo['homeTeam'])
		{
			$awayTeamInfo = $homeTeamInfo;
			$homeTeamInfo = mysqli_fetch_array($db_team_info_query_result);
		}
		else
			$awayTeamInfo = mysqli_fetch_array($db_team_info_query_result);

		$showResults = false;
		if (time() > mktime(getHourFromMySQLTime($gameInfo['time']) + 1, getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date'])))
			$showResults = true;
?>
		<div id="game-info">
			<p><?= $gameInfo['description'] ?></p>
			<?php $gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date'])); ?>
			<p><?= date('l\, F j\, Y', $gameTime) ?></p>
			<p><?= date('g\:i', $gameTime) ?></p>
			<p><?php echo $gameInfo['park'] . ", Field #" . $gameInfo['field']; ?></p>
					
		</div> <!-- game-info -->

TODO get regular season record (ONLY UP TO the game date?)
		<div id="home-team">
			<h2>Home - <a href="team-profile.php?id=<?= $homeTeamInfo['teamID'] ?>"><?= $homeTeamInfo['name'] ?></a></h2>
			<img alt="<?= $homeTeamInfo['name'] ?>" src="images/team-no-image.png" />
		</div> <!-- home-team -->
		
		<div id="away-team">
			<h2>Away - <a href="team-profile.php?id=<?= $awayTeamInfo['teamID'] ?>"><?= $awayTeamInfo['name'] ?></a></h2>
			<img alt="<?= $awayTeamInfo['name'] ?>" src="images/team-no-image.png" />
		</div> <!-- away-team -->
		<?php
			if ($showResults)
			{
		?>
		<div id="final-score">
			<p>Final Score</p>
			<p><?= $gameInfo['finalHomeScore'] ?> - <?= $gameInfo['finalVisitingScore'] ?></p>
		</div> <!-- final-score -->
		<?php
			}
		?>
<?php
	}
	else
//TODO don't use die(), and close the db if needed
		die("I need a gameid.");

	closeDB($db_con);

?>

	</body>
</html>
