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

function getLeagueInfo($leagueID)
{
    $qResult = runQuery("SELECT L.*, C.Name FROM League AS L JOIN Class AS C ON L.ClassID = C.ID WHERE L.ID = $leagueID");

    if ($qResult)
        return mysqli_fetch_array($qResult);

    return null;
}

function getLeagueDescription($leagueInfo)
{
    if ($leagueInfo)
        return $leagueInfo['Description'] . ' (' . getLeagueClass($leagueInfo) . ')';

    return '';
}

function getLeagueClass($leagueInfo)
{
    if ($leagueInfo)
        return $leagueInfo['Name'];

    return '';
}

function getLeaguesForTeam($teamInfo)
{
    $qResult = runQuery("SELECT L.ID AS ID, L.Description, C.Name FROM Team AS T JOIN ParticipatesIn AS P ON T.ID = P.TeamID JOIN League AS L ON P.LeagueId = L.ID JOIN Class AS C ON L.ClassID = C.ID WHERE T.ID = {$teamInfo['ID']} ORDER BY L.StartDate DESC");

    if ($qResult) {
        $result = array();
        while($row = mysqli_fetch_array($qResult)) {
            $result[] = $row;
        }

        return $result;
    }

    return null;
}

function getTeamsInLeague($leagueInfo)
{
    $qResult = runQuery("SELECT T.* FROM League AS L JOIN Class AS C ON L.ClassID = C.ID JOIN ParticipatesIn AS P ON P.LeagueID = L.ID JOIN Team AS T ON P.TeamID = T.ID WHERE L.ID = {$leagueInfo['ID']}");

    if ($qResult) {
        $toReturn = array();

        while ($row = mysqli_fetch_array($qResult)) {
            $toReturn[] = $row;
        }

        return $toReturn;
    }

    return null;
}

function getLeagueURI($leagueInfo)
{
    return "/league/{$leagueInfo['ID']}";
}

