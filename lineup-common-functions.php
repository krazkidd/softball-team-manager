<?php

/* *************************************************************************

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
  
************************************************************************* */

require_once("common-definitions.php");

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

function isValidMySQLDateString($dateString)
{
//DEBUG
echo "Invalid date string.\n";
//END DEBUG
	// the string must look like 'YYYY-MM-DD'
	return checkdate(substr($dateString, 5, 2), substr($dateString, 7, 2), substr($dateString, 0, 4));
}

/*
 * getNextGames -- returns the next $numGames games after the given date, formatted as a valid MySQL string, in the user's preferred season
 */
function getNextGames($numGames, $MySQLDateString)
{
	if ( !isValidMySQLDateString($MySQLDateString))
		return NULL;

	$db_con = connectToDB();
	$toReturn = mysqli_query($db_con, "SELECT * FROM games JOIN leagues ON games.associatedLeague = leagues.leagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE seasons.seasonID = " . getUserSeasonID() . " WHERE games.date >= $MySQLDateString ORDER BY games.date LIMIT $numGames");
	closeDB($db_con);
	return $toReturn;
}

/*
 * getLineup --  returns an array of player information from the db where the indices are the batting order, between 1 and 12 inclusive. Players 11 and 12 are extra players that can bat. Extra players that are non-starter substitutes are indexed as "EP{1..5}"
 */
function getLineup($gameID, $teamID)
{
//ERROR keep track of starters/non-starters instead of doing all this weird condition checking. batPos will be NULL for non-starters (and obviously, for EP{3,4,5}, batPos doesnt exist). 
//how am i storing ep1/ep2 in the db? numbers 11 & 12? these two need to be treated specially everywhere. if the team is co-ed and these two are male-female, put them in the batting order. otherwise they go down below

	$db_con = connectToDB();

	// get the player IDs of everybody in the lineup for the game
//TODO it's possible to have *2* lineups. so obviously you need to be querying the user's team id too. allow user to see other lineups only after the game is finished
//TODO this seems to be getting duplicated results. i wonder why.
	$lineupPlayerIDs = mysqli_fetch_array(mysqli_query($db_con, "SELECT pos1, pos2, pos3, pos4, pos5, pos6, pos7, pos8, pos9, pos10, EP1, EP2, EP3, EP4, EP5 FROM lineups WHERE associatedGame = $gameID"));
	// use the IDs to query player information
	$db_player_query_result = mysqli_query($db_con, "SELECT playerID, firstName, lastName, shirtNumber, gender FROM players WHERE playerID IN (" . implode(", ", array_filter($lineupPlayerIDs)) . ")");

//TODO make function to get player info from list of player IDs
	$playerInfo = Array();
	$count = 0;
	foreach($db_player_query_result as $p)
	{
		$playerInfo[$p["playerID"]] = $p;
		$count++;	
	}

	// get batting order for positions
//TODO is this also duplicating results like in getLineup()?
	$battingOrder = mysqli_fetch_array(mysqli_query($db_con, "SELECT batPos1, batPos2, batPos3, batPos4, batPos5, batPos6, batPos7, batPos8, batPos9, batPos10, batPosEP1, batPosEP2 FROM lineups WHERE associatedGame = $gameID"));
//DEBUG
//echo "Batting order: " . implode(", ", $battingOrder);
//END DEBUG
	closeDB($db_con);

	$starters = Array();
	for ($i = 1; $i < 10; $i++)
	{
		if ($lineupPlayerIDs["pos$i"]) //TODO this seems like an unnecessary condition
		{
			$starters[$battingOrder["batPos$i"]] = $playerInfo[$lineupPlayerIDs["pos$i"]];
			// tack on the alphabetic position initials
//TODO okay, problem: the positions change depending on number of players. CF is synonomous with LC and Rover with RC, but I need to do this in a way that's not confusing for the user
//* maybe show "LC (CF)" while the number of players is not known, and either "LC" or "CF" when it is
			$starters[$battingOrder["batPos$i"]]["position"] = convertNumberedFieldPositionToAlpha($i);


//ERROR this above is exactly what should be done in the functions i wrote today
// what the F was i talking about in the line above?


		}
	}

//NOTE if there are non-fielding (but batting) starters, put them in the starters array
	$nonstarters = Array();



//TODO because i am only returning one array, i need to combine starters and non-starters here
//     or retrieve either in different functions




	if (isset($lineupPlayerIDs["EP1"]) && isset($battingOrder["batPosEP1"]))
	{
		$starters[$battingOrder["batPosEP1"]] = $playerInfo[$lineupPlayerIDs["EP1"]];
		$starters[$battingOrder["batPosEP1"]]["position"] = "EP1";
	}
	else if (isset($lineupPlayerIDs["EP1"]))
		$nonstarters["EP1"] = $playerInfo[$lineupPlayerIDs["EP1"]];

	if (isset($lineupPlayerIDs["EP2"]) && isset($battingOrder["batPosEP2"]))
	{
		$starters[$battingOrder["batPosEP2"]] = $playerInfo[$lineupPlayerIDs["EP2"]];
		$starters[$battingOrder["batPosEP2"]]["position"] = "EP2";
	}
	else if (isset($lineupPlayerIDs["EP2"]))
		$nonstarters["EP2"] = $playerInfo[$lineupPlayerIDs["EP2"]];

	if (isset($lineupPlayerIDs["EP3"]))
		$nonstarters["EP3"] = $playerInfo[$lineupPlayerIDs["EP3"]];
	if (isset($lineupPlayerIDs["EP4"]))
		$nonstarters["EP4"] = $playerInfo[$lineupPlayerIDs["EP4"]];
	if (isset($lineupPlayerIDs["EP5"]))
		$nonstarters["EP5"] = $playerInfo[$lineupPlayerIDs["EP5"]];

	return $starters;
}

/*
 *	getGameInfo --
 */
function getGameInfo($gameID)
{
//TODO sanity checks?
	$db_con = connectToDB();
	return mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM games WHERE gameID = $gameID"));
	closeDB($db_con);
}

?>
