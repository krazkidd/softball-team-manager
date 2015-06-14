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

//TODO all this controller logic needs to go in controllers file

$title = 'Field Layout';

ob_start();

?><?php
	if ( !isset($_GET["id"]))
	{
		$db_next_games_query_result = getNextGames(6, date("Y-m-d"));

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
<?php
	}

	$lineup = getLineup($_GET["gameid"], NULL);
	$starters = $lineup;

	$gameInfo = getGameInfo($_GET["gameid"]);
/*
//TODO don't use NULL here...
	$lineupPlayerIDs = getLineupPlayerIDs($_GET["gameid"], NULL);
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
			//$starters[$lineupBatPos["batPos$i"]]["position"] = convertNumberedFieldPositionToAlpha($i);
		}
	}

	// check the extra players. if there is an extra male and female, they belong in the starting lineup
//TODO do some more checking, like for gender. set a note to check that extra players are put into the database correctly
	if (isset($lineupPlayerIDs["EP1"]) && isset($lineupBatPos["batPosEP1"]))
	{
		$starters[$lineupBatPos["batPosEP1"]] = $players[$lineupPlayerIDs["EP1"]];
		$starters[$lineupBatPos["batPosEP1"]]["position"] = "EP1";
	}
	else if (isset($lineupPlayerIDs["EP1"]))
		$nonstarters["EP1"] = $players[$lineupPlayerIDs["EP1"]];

	if (isset($lineupPlayerIDs["EP2"]) && isset($lineupBatPos["batPosEP2"]))
	{
		$starters[$lineupBatPos["batPosEP2"]] = $players[$lineupPlayerIDs["EP2"]];
		$starters[$lineupBatPos["batPosEP2"]]["position"] = "EP2";
	}
	else if (isset($lineupPlayerIDs["EP2"]))
		$nonstarters["EP2"] = $players[$lineupPlayerIDs["EP2"]];

	if (isset($lineupPlayerIDs["EP3"]))
		$nonstarters["EP3"] = $players[$lineupPlayerIDs["EP3"]];
	if (isset($lineupPlayerIDs["EP4"]))
		$nonstarters["EP4"] = $players[$lineupPlayerIDs["EP4"]];
	if (isset($lineupPlayerIDs["EP5"]))
		$nonstarters["EP5"] = $players[$lineupPlayerIDs["EP5"]];
	*/

	$gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date']));
?>

		<h3><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></h3>

		<div id="softballField">
<?php
	for ($i = 1; $i <= count($starters); $i++)
	{
//TODO write a function to return gender CSS class! because there is -male, -female, and -missing and i don't want to use nested ?: things
?>

			<div id="field-pos-<?= $i ?>" class="playerPos gender-<?= $starters[$i]["gender"][0] == "M" ? "male" : "female" ?>">
				<p>#<?= $starters[$i]["shirtNumber"] ?> <?= $starters[$i]["firstName"] ?> <?= $starters[$i]["lastName"][0] ?>.</p>
			</div>
<?php
	}
?>

		</div>

<?php
		if (count($nonstarters) > 0)
		{
?>
		<div id="extra-player-list">
			<p>Extra players:</p>
			<ul>
<?php
			if ($lineupBatPos["batPosEP1"] && $lineupBatPos["batPosEP2"])
			{
?>
				<li class="ep-is-starter">#<?= $starters["EP1"]["shirtNumber"] ?> <?= $starters["EP1"]["firstName"] . " " . $starters["EP1"]["lastName"] ?> is in the batting order!</li>
				<li class="ep-is-starter">#<?= $starters["EP2"]["shirtNumber"] ?> <?= $starters["EP2"]["firstName"] . " " . $starters["EP1"]["lastName"] ?> is in the batting order!</li>
<?php
			}
			else
			{
				if ($nonstarters["EP1"])
				{
?>
				<li>#<?= $nonstarters["EP1"]["shirtNumber"] ?> <?= $nonstarters["EP1"]["firstName"] . " " . $nonstarters["EP1"]["lastName"] ?></li>
<?php
				}
				if ($nonstarters["EP2"])
				{
?>
				<li>#<?= $nonstarters["EP2"]["shirtNumber"] ?> <?= $nonstarters["EP2"]["firstName"] . " " . $nonstarters["EP2"]["lastName"] ?></li>
<?php
				}
			}

//TODO add EP6
			for ($i = 3; $i <= 5; $i++)
			{
				if ($nonstarters["EP$i"])
				{
?>
				<li>#<?= $starters["EP$i"]["shirtNumber"] ?> <?= $nonstarters["EP$i"]["firstName"] . " " . $nonstarters["EP1"]["lastName"] ?></li>
<?php
			}
?>
			</ul>
<?php
		}
?>
		</div>
<?php
	}

$content = ob_get_clean();

require '../templates/layout.php';
