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

//require_once "../models/common-definitions.php";
//require_once "../models/calendar.php";
require_once "../models/lineup.php";

if ( !isLoggedIn())
{
    header('Location: /');
//TODO is exit() okay here? Anyway, an error message should be shown to the user.
//TODO user must have permissions to view their lineup
    exit();
}

if ( !isset($_GET["id"]))
{
//TODO have getNextGames return a regular array instead of a mysql result
    $db_next_games_query_result = getNextGames(6, date("Y-m-d"));

    $thisFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $thisFile);
    $thisFile = $parts[count($parts) - 1];

    while ($row = mysqli_fetch_array($db_next_games_query_result))
    {
        $gameTime = mktime(getHourFromMySQLTime($row['time']), getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date']));
    }

    //exit();
}

$gameInfo = getGameInfo($_GET["gameid"]);
//TODO change this from NULL
$lineup = getLineup($_GET["gameid"], NULL);

//ERROR need to pull starters/non-starters from lineup?
$starters = $lineup;

$gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date']));

require '../views/lineup.php';

require 'end_controller.php';
