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

session_start();

require_once '../models/auth.php';

doRequireLogin();

//require_once '../models/common-definitions.php';
require_once '../models/calendar.php';

if ( !isset($_GET["id"]))
{
    //TODO have getNextGames return a regular array instead of a mysql result
    $nextGames = getNextGames(6, date("Y-m-d"));

    for($nextGames as $gameInfo)
    {
        //TODO why am i setting this in a loop? $gameTime = mktime(getHourFromMySQLTime($row['time']), getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date']));
    }
}

	$lineup = getLineup($_GET["id"], NULL);
	$starters = $lineup;

	$gameInfo = getGameInfo($_GET["id"]);
/*
//TODO don't use NULL here...
	$lineupPlayerIDs = getLineupPlayerIDs($_GET["gameid"], NULL);
//TODO this returns double results...or implode() double-prints...
	$lineupBatPos = mysqli_fetch_array(mysqli_query($db_con, "SELECT batPos1, batPos2, batPos3, batPos4, batPos5, batPos6, batPos7, batPos8, batPos9, batPos10, batPosEP1, batPosEP2 FROM lineups WHERE associatedGame = {$_GET["gameid"]}"));
	$gameInfo = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM games WHERE gameID = {$_GET["gameid"]}"));

//TODO this seems to be getting double results. i wonder why.
$db_player_query_result = mysqli_query($db_con, "SELECT playerID, firstName, lastName, shirtNumber, gender FROM players WHERE playerID IN (" . implode(", ", array_filter($lineupPlayerIDs)) . ")");
// put the players returned from the query in an Array, indexed by their player ID
$players = Array();
while ($row = mysqli_fetch_array($db_player_query_result))
{
    $players[$row["playerID"]] = $row;
}

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

require '../views/field-layout.php';

require 'end_controller.php';
