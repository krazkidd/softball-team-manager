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

require_once dirname(__FILE__) . '/model.php';
require_once dirname(__FILE__) . '/player.php';

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
    global $posArray;

    if ( !$posArray)
        doBuildPosArray();

    if ($posArray && $pos >= 1 && $pos <= 10)
    {
        $name = $posArray[$pos][1];
        if ($name)
            return $name;
    }

    return 'EH';
}

function getPosName($pos)
{
    global $posArray;

    if ( !$posArray)
        doBuildPosArray();

    if ($posArray && $pos >= 1 && $pos <= 10)
    {
        $name = $posArray[$pos][0];
        if ($name)
            return $name;
    }

    return 'Extra Hitter';
}

/*
 * getLineup --
 */
function getLineup($gameID, $teamID, $leagueID)
{
    $qResult = runQuery("SELECT * FROM Lineup AS L WHERE L.GameID = $gameID AND L.TeamID = $teamID AND L.LeagueID = $leagueID");

    if ($qResult)
        return mysqli_fetch_array($qResult);

    return NULL;
}

function getPlayerIDAtFieldPos($lineup, $pos)
{
    if ($pos >= 1 && $pos <= 10)
    {
        return $lineup["FieldPos{$pos}PID"];
    }

    return -1;
}

function getPlayerIDAtBatPos($lineup, $pos)
{
    if ($pos >= 1 && $pos <= 12)
        return $lineup["BatPos{$pos}PID"];

    return -1;
}

function getFieldPosForPlayer($lineup, $playerInfo)
{
    // get player's DB ID
    $pid = getPlayerID($playerInfo);

    // loop through field pos #'s
    for ($i = 1; $i <= 10; $i++)
    {
        // get the player ID at that field pos
        $pidAtPos = getPlayerIDAtFieldPos($lineup, $i);

        if ($pidAtPos == $pid)
            return $i;
    }

    return 0;
}

function getPositions($lineup)
{
    $toReturn = array();

    for ($i = 1; $i <= 10; $i++)
    {
        $pid = getPlayerIDAtFieldPos($lineup, $i);
        if ($pid >= 0) //TODO >= 0?
        {
            $player = getPlayerInfo($pid);
            if ($player)
                $toReturn[$i] = $player;
            else
                $toReturn[$i] = NULL;
        }
    }

    return $toReturn;
}

function getBattingOrder($lineup)
{
    $toReturn = array();

    for ($i = 1; $i <= 12; $i++)
    {
        $pid = getPlayerIDAtBatPos($lineup, $i);
        if ($pid >= 0) //TODO >= 0?
        {
            $player = getPlayerInfo($pid);
            if ($player)
                $toReturn[$i] = $player;
            else
                $toReturn[$i] = NULL;
        }
    }

    return $toReturn;
}

function getExtraPlayers($lineup)
{
    $toReturn = array();

    for ($i = 1; $i <= 3; $i++)
    {
        $pid = getExtraPlayerID($lineup, $i);
        if ($pid >= 0)
        {
            $player = getPlayerInfo($pid);
            $toReturn[$i] = $player;
        }
        else
            $toReturn[$i] = NULL;
    }

    return $toReturn;
}

function getExtraPlayerID($lineup, $epNum)
{
    if ($lineup["ExtraPlayer{$epNum}PID"])
        return $lineup["ExtraPlayer{$epNum}PID"];

    return -1;
}

function hasExtraPlayers($lineup)
{
    return getExtraPlayerID($lineup, 1) > -1 || getExtraPlayerID($lineup, 2) > -1 || getExtraPlayerID($lineup, 3) > -1;
}

function getLineupURI($lineup)
{
    return "/lineup?gameid={$lineup['GameID']}&teamid={$lineup['TeamID']}&leagueid={$lineup['LeagueID']}";
}

function getFieldLayoutURI($lineup)
{
    return "/field-layout?gameid={$lineup['GameID']}&teamid={$lineup['TeamID']}&leagueid={$lineup['LeagueID']}";
}

function getShirtNum($lineup, $player)
{
    $qResult = runQuery("SELECT ShirtNum FROM Roster AS R WHERE R.PlayerID = {$player['ID']} AND R.TeamID = {$lineup['TeamID']} AND R.LeagueID = {$lineup['LeagueID']}");
    if ($qResult)
        return mysqli_fetch_array($qResult)['ShirtNum'];

    return '';
}
