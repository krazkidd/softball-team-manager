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

require 'begin-controller.php';

require_once '../models/auth.php';

doRequireLogin();

require_once '../models/calendar.php';
require_once '../models/lineup.php';

if (isset($id))
    $gameID = $id;
else
    $gameID = 0;

//TODO have getNextGames return a regular array instead of a mysql result
$nextGames = getNextGames(6, date("Y-m-d"));

foreach ($nextGames as $gameInfo)
{
    //TODO why am i setting this in a loop? $gameTime = mktime(getHourFromMySQLTime($row['time']), getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date']));
}

//TODO id is lineup id: $gameInfo = getGameInfo($_GET['id']);
//TODO change this from NULL




ERROR changed this functions arg list

$lineup = getLineup($_GET['id'], NULL);

//ERROR need to pull starters/non-starters from lineup?
$starters = $lineup;

$gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date']));

require '../views/lineup.php';

require 'end-controller.php';
