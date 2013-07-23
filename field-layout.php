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

//TODO it's possible to have *2* lineups. so obviously you need to be querying the user's team id too
	$lineupPlayerIDs = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM lineups WHERE associatedGame = {$_GET["gameid"]}"));
	$gameInfo = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM games WHERE gameID = {$_GET["gameid"]}"));
//DEBUG
// show an error if the query failed
if ($lineupPlayerIDs == NULL)
  echo "<p class=\"db-error\">The lineup result was NULL :(</p>";
//END DEBUG

	$playerIDList = implode(",", $lineupPlayerIDs);
//TODO this seems to be getting double results. i wonder why.
	$db_player_query_result = mysqli_query($db_con, "SELECT playerID, firstName, lastName, shirtNumber FROM players WHERE playerID IN ($playerIDList)");

//TODO there has got to be an easier way to do this.....I really can't think of it right now
//TODO I probably want to show gender as well, so I'm really going to need a way to loop either through the IDs or the positions and record everything in a big array
	$lineup = Array();
	if ($lineupPlayerIDs["P"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["P"]}"));
		$lineup["P"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["C"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["C"]}"));
		$lineup["C"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["1B"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["1B"]}"));
		$lineup["1B"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["2B"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["2B"]}"));
		$lineup["2B"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["3B"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["3B"]}"));
		$lineup["3B"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["SS"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["SS"]}"));
		$lineup["SS"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["LF"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["LF"]}"));
		$lineup["LF"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["CF"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["CF"]}"));
		$lineup["CF"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["RF"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["RF"]}"));
		$lineup["RF"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["RC"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["RC"]}"));
		$lineup["RC"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["EP1"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["EP1"]}"));
		$lineup["EP1"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["EP1"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["EP1"]}"));
		$lineup["EP1"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["EP2"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["EP2"]}"));
		$lineup["EP2"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["EP3"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["EP3"]}"));
		$lineup["EP3"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["EP4"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["EP4"]}"));
		$lineup["EP4"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}
	if ($lineupPlayerIDs["EP5"])
	{
		$player = mysqli_fetch_array(mysqli_query($db_con, "SELECT firstName, lastName, shirtNumber FROM players WHERE playerID = {$lineupPlayerIDs["EP5"]}"));
		$lineup["EP5"] = $player["firstName"] . " " . $player["lastName"] . " #" . $player["shirtNumber"];
	}

	closeDB($db_con);

	$gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date']));
?>

TODO I need to space the names better (but really I need an original field image) so they can't overlap (make sure the names won't wrap either)
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

		<p>View the batting order in a table format on the <a href="lineup.php?gameid=<?= $_GET["gameid"] ?>">Lineup</a> page.</p>

	</body>
</html>

