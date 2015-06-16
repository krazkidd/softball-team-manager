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

require_once 'model.php';
require_once '../models/player.php'; //TODO without '../models/', this called views/player.php. WHY?

$posArray = NULL;

function doBuildPosArray()
{
    global $posArray;
    $posArray = NULL;

    $query_result = runQuery("SELECT * FROM FieldPosition");

    while($row = mysqli_fetch_array($query_result))
    {
        $posArray[$row['PosNum']] = array($row['PosName'], $row['ShortPosName']);
    }
}

function getShortPosName($pos)
{
//	switch ($pos)
//	{
//		case 1:
//			return "P";
//		case 2:
//			return "C";
//		case 3:
//			return "1B";
//		case 4:
//			return "2B";
//		case 5:
//			return "3B";
//		case 6:
//			return "SS";
//		case 7:
//			return "LF";
//		case 8:
//			return "CF";
//		case 9:
//			return "RF";
//		case 10:
//			return "RC";
//TODO do i want to use cases 11 and 12 for EP1 and EP2?
//		default:
//			return "Invalid Position";
//	}

    if ( !$posArray)
    {
        doBuildPosArray();
    }

    if ( !$posArray)
            return '';

    $name = $posArray[$pos][1];

    if ( !$name)
        return '';

    return $name;
}

function getPosName($pos)
{
    if ( !$posArray)
    {
        doBuildPosArray();
    }

    if ( !$posArray)
            return '';

    $name = $posArray[$pos][0];

    if ( !$name)
        return '';

    return $name;
}

/*
 * getLineup --  returns an array of player information from the db where the indices are the batting order, between 1 and 12 inclusive. Players 11 and 12 are extra players that can bat. Extra players that are non-starter substitutes are indexed as "EP{1..5}"
 */
function getLineup($gameID, $teamID, $leagueID)
{
	return mysqli_fetch_array(runQuery("SELECT * FROM Lineup AS L WHERE L.GameID = $gameID AND L.TeamID = $teamID AND L.LeagueID = $leagueID"));
}

function getPlayerAtFieldPos($lineup, $pos)
{
     return getPlayerInfo($lineup["FieldPos{$pos}PID"]);
}

function getPlayerAtBatPos($lineup, $pos)
{
     return getPlayerInfo($lineup["BatPos{$pos}PID"]);
}

function getSubs($lineup)
{
    $toReturn = array();

    $i = 0;
    $qResult = runQuery("SELECT * FROM Player AS P WHERE P.ID IN ({$lineup['ExtraPlayer1PID']}, {$lineup['ExtraPlayer2PID']}, {$lineup['ExtraPlayer3PID']}");
    while ($row = mysqli_fetch_array($qResult))
    {
        $toReturn[$i] = $row;
        $i++;
    }

    return $toReturn;
}

//TODO for other function ideas, e.g. getStarters(), see this file before 15 june 2015
