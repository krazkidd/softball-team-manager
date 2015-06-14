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

require_once "../models/calendar.php";

if (isset($_GET['id']))
{
    //$db_game_info_query_result = runQuery("SELECT * FROM Game AS G JOIN League AS L ON G.LeagueID = L.ID JOIN Season AS S ON L.SeasonID = S.ID JOIN Team AS T1 ON G.HomeID = T1.ID JOIN Team AS T2 ON Game.AwayID = T2.ID WHERE G.ID = {$_GET['id']}");
    $db_game_info_query_result = runQuery("SELECT * FROM Game WHERE ID = {$_GET['id']}");
    $gameInfo = mysqli_fetch_array($db_game_info_query_result);
    //TODO allow for home/away to be null and show 'TBD' or somesuch
    $homeID = $gameInfo['HomeID'];
    $awayID = $gameInfo['AwayID'];
    $db_home_team_info_query_result = runQuery("SELECT * FROM Game AS G JOIN Team AS T ON G.HomeID = T.ID WHERE G.ID = " . $_GET['id'] . " AND T.ID = " . $homeID);
    $db_away_team_info_query_result = runQuery("SELECT * FROM Game AS G JOIN Team AS T ON G.AwayID = T.ID WHERE G.ID = " . $_GET['id'] . " AND T.ID = " . $awayID);

    $gameTime = mktimeFromMySQLDateTime($gameInfo['DateTime']);
    $homeTeamInfo = mysqli_fetch_array($db_home_team_info_query_result);
    $awayTeamInfo = mysqli_fetch_array($db_away_team_info_query_result);

    $showResults = false;
    if (time() > $gameTime)
        $showResults = true;
}

require '../views/game.php';

require 'end_controller.php';
