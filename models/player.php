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

function getPlayerInfo($playerID)
{
    //TODO sanitize param (and all params in every db call)
    if ($playerID)
    {
        $qResult = runQuery("SELECT * FROM Player WHERE Player.ID = $playerID");

        if ($qResult)
            return mysqli_fetch_array($qResult);
    }

    return NULL;
}

function getFormattedPhoneNumber($player)
{
    if ($player)
    {
        $phoneStr = $player['PhoneNumber'];

        if ( !empty($phoneStr))
        {
            if (strlen($phoneStr) == 10)
                return '(' . substr($phoneStr, 0, 3) . ') ' . substr($phoneStr, 3, 3) . '-' . substr($phoneStr, 6, 4);
            else if (strlen($phoneStr) == 7)
                return substr($phoneStr, 0, 3) . '-' . substr($phoneStr, 3, 4);
        }
    }

    return '';
}

function getEmail($player)
{
    if ($player)
        return $player['Email'];

    return '';
}

function getRosteredTeamsForPlayer($pid)
{
    if (isID($pid))
    {
        $qResult = runQuery("SELECT T.ID, T.TeamName, L.Description, C.Name FROM Team AS T JOIN Roster AS R ON T.ID = R.TeamID JOIN ParticipatesIn AS P ON P.TeamID = T.ID JOIN League AS L ON P.LeagueID = L.ID JOIN Class AS C ON L.ClassID = C.ID WHERE R.PlayerID = $pid ORDER BY L.StartDate DESC");

        if ($qResult)
        {
            $result = array();
            while($row = mysqli_fetch_array($qResult))
            {
                $result[] = $row;
            }

            return $result;
        }
    }

    return NULL;
}

function getPlayerURI($player)
{
    if ($player)
        return "/player/{$player['ID']}";

    return '#';
}

function getFirstName($player)
{
    if ($player)
        return $player['FirstName'];

    return '';
}

function getFullName($player)
{
    if ($player)
        return $player['FirstName'] . ' ' . $player['LastName'];

    return '';
}

function getShortName($player)
{
    if ($player)
        return $player['FirstName'] . ' ' . $player['LastName'][0] . '.';

    return '';
}

function getNickName($player)
{
    if ($player)
        return $player['NickName'];

    return '';
}

function getGender($player, $lowerCase)
{
    if ($player)
        return $lowerCase ? strtolower($player['Gender']) : $player['Gender'];

    return '';
}

function getPlayerID($playerInfo)
{
    if ($playerInfo)
        return $playerInfo['ID'];

    return -1;
}

function getManagedTeamsForPlayer($pid)
{
    if (isID($pid + 0))
    {
        $qResult = runQuery("SELECT T.ID, T.TeamName FROM Team AS T WHERE T.ManagerID = $pid");

        if ($qResult)
        {
            $result = array();
            while($row = mysqli_fetch_array($qResult))
            {
                $result[] = $row;
            }

            return $result;
        }
    }

    return NULL;
}
