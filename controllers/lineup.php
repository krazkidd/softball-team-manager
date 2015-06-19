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
require_once dirname(__FILE__) . '/../models/league.php';

if (isset($_GET['gameid']) && isset($_GET['teamid']) && isset($_GET['leagueid']) 
  && isID($_GET['gameid']) && isID($_GET['teamid']) && isID($_GET['leagueid']))
{
    $gameID = $_GET['gameid'];
    $leagueID = $_GET['leagueid'];
    $teamID = $_GET['teamid'];

    $lineup = getLineup($gameID, $teamID, $leagueID);

    $teamInfo = getTeamInfo($teamID);
    $teamName = getTeamName($teamInfo);
    $mgrName = getFullName(getTeamManagerInfo($teamInfo));
    unset($teamInfo);

    $leagueInfo = getLeagueInfo($leagueID);
    $leagueDesc = getLeagueDescription($leagueInfo);
    unset($leagueInfo);

    $gameInfo = getGameInfo($gameID);
    $gameTime = mktimeFromMySQLDateTime($gameInfo['DateTime']);
    unset($gameInfo);

    unset($teamID);
    unset($gameID);
    unset($leagueID);
    unset($teamInfo);

    require_once dirname(__FILE__) . '/../views/lineup.php';
}
else
{
    $msgTitle = "Bad Lineup Request";
    $msg = "Your request didn't have a valid combination of gameid, teamid, and leagueid.";
    $msgClass = "failure";
    require_once dirname(__FILE__) . '/../views/show-message.php';
}

//TODO allow user to see others' lineups only after the game is finished


require 'end-controller.php';
