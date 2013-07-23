<?php
	session_start();
	require_once("common-definitions.php");
	require_once("calendar-common-functions.php");

	if (!isLoggedIn())
	{
		header("Location: index.php");
//TODO is exit() okay here? Anyway, an error message should be shown to the user.
		exit();
	}

	$db_con = connectToDB();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show game info in title -->
		<title>Field Layout</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="field-layout-body">

		<div id="field-layout-header">
			<h1>Field Layout</h1>
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

//TODO get next game data (or user-select game from GET/POST) 

//TODO it's possible to have *2* lineups. so obviously you need to be querying the user's team id too
		$lineupPlayerIDs = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM lineups WHERE associatedGame = {$_GET["gameid"]}"));
		$gameInfo = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM games WHERE gameID = {$_GET["gameid"]}"));
//DEBUG
// show an error if the query failed
if ($lineupPlayerIDs == NULL)
  echo "<p class=\"db-error\">The lineup result was NULL :(</p>";
//END DEBUG

	$playerIDList = implode(",", $lineup);
//TODO this seems to be getting double results. i wonder why.
	$db_player_query_result = mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID IN ($playerIDList)");

	
	$lineup = Array(
	            "P" => 
	

	closeDB($db_con);

	$gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date']));
?>

TODO make the date prettier; use long month name (and above too, in the list of the next few games)
		<div id="softballField">
			<div id="gameInfo">
				<p><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></p>
			</div>

			<div id="pitcher" class="playerPos">
				<p><?= $lineup["P"] ?></p>
			</div>

			<div id="catcher" class="playerPos">
				<p><?= $lineup["C"] ?></p>
			</div>

			<div id="firstBaseman" class="playerPos">
				<p><?= $lineup["1B"] ?></p>
			</div>

			<div id="secondBaseman" class="playerPos">
				<p><?= $lineup["2B"] ?></p>
			</div>

			<div id="thirdBaseman" class="playerPos">
				<p><?= $lineup["3B"] ?></p>
			</div>

			<div id="shortstop" class="playerPos">
				<p><?= $lineup["SS"] ?></p>
			</div>

			<div id="leftFielder" class="playerPos">
				<p><?= $lineup["LF"] ?></p>
			</div>

			<div id="centerFielder" class="playerPos">
				<p><?= $lineup["CF"] ?></p>
			</div>

			<div id="rightFielder" class="playerPos">
				<p><?= $lineup["RF"] ?></p>
			</div>

			<div id="rover" class="playerPos">
				<p><?= $lineup["RC"] ?></p>
			</div>
		</div>
<?php
	if ($lineup["EP1"] || $lineup["EP2"] || $lineup["EP3"] || $lineup["EP4"] || $lineup["EP5"])
	{
?>
		<div id="extra-player-list">
			<p>Extra players:</p>
			<ul>
				<?= $lineup["EP1"] ? "<li>{$lineup["EP1"]}</li>\n" : "" ?>
				<?= $lineup["EP2"] ? "<li>{$lineup["EP2"]}</li>\n" : "" ?>
				<?= $lineup["EP3"] ? "<li>{$lineup["EP3"]}</li>\n" : "" ?>
				<?= $lineup["EP4"] ? "<li>{$lineup["EP4"]}</li>\n" : "" ?>
				<?= $lineup["EP5"] ? "<li>{$lineup["EP5"]}</li>\n" : "" ?>
			</ul>
		</div>
<?php
	}
?>

	</body>
</html>

