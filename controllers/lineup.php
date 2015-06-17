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

require dirname(__FILE__) . '/begin-controller.php';

require_once dirname(__FILE__) . '/../models/auth.php';

doRequireLogin();

require_once dirname(__FILE__) . '/../models/calendar.php';
require_once dirname(__FILE__) . '/../models/lineup.php';
require_once dirname(__FILE__) . '/../models/game.php';
require_once dirname(__FILE__) . '/../models/team.php';

if (isset($_GET['gameid']) && isset($_GET['teamid']) && isset($_GET['leagueid']) 
  && isID($_GET['gameid']) && isID($_GET['teamid']) && isID($_GET['leagueid']))
{
    $isReqValid = true; //TODO rename; tells the view code that all needed arguments are present

    $gameID = $_GET['gameid'];
    $teamID = $_GET['teamid'];
    $leagueID = $_GET['leagueid'];

    $teamInfo = getTeamInfo($teamID);
    $lineup = getLineup($gameID, $teamID, $leagueID);
    $gameInfo = getGameInfo($gameID);
    $gameTime = mktimeFromMySQLDateTime($gameInfo['DateTime']);
}

//TODO allow user to see others' lineups only after the game is finished

require '../views/lineup.php';

require 'end-controller.php';
