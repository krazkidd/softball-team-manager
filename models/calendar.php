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

function getHourFromMySQLTime($timeString)
{
    return substr($timeString, 11, 2);
}

function getMinuteFromMySQLTime($timeString)
{
    return substr($timeString, 14, 2);
}

function getYearFromMySQLDate($dateString)
{
    return substr($dateString, 0, 4);
}

function getMonthFromMySQLDate($dateString)
{
    return substr($dateString, 5, 2);
}

function getDayFromMySQLDate($dateString)
{
//TODO check for null argument?
    return substr($dateString, 8, 2);
}

function mktimeFromMySQLDateTime($timeString)
{
    return mktime(getHourFromMySQLTime($timeString), getMinuteFromMySQLTime($timeString), 0, getMonthFromMySQLDate($timeString), getDayFromMySQLDate($timeString), getYearFromMySQLDate($timeString));
}

/* the string must look like 'YYYY-MM-DD' */
function isValidMySQLDateString($dateString)
{
    return checkdate(substr($dateString, 5, 2), substr($dateString, 7, 2), substr($dateString, 0, 4));
}

/*function getGamesByDate($dateStr)
{
//TODO make sure date argument is in proper format
//TODO fix query
    $qResult = runQuery("SELECT * FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE date = '{$_GET['date']}' ORDER BY time");

    if ($qResult) {
        $result = array();
        while ($row = mysqli_fetch_array($db_game_info_query_result)) {
            $result[] = $row;
        }

        return $result;
    }

    return null;
}*/

function getCalendarURI($leagueInfo)
{
    return "/calendar/{$leagueInfo['ID']}";
}

