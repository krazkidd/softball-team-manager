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

require_once dirname(__FILE__) . '/../models/roster.php';
require_once dirname(__FILE__) . '/../models/game.php';
require_once dirname(__FILE__) . '/../models/team.php';
require_once dirname(__FILE__) . '/../models/league.php';

if (isset($teamID) && isset($leagueID)) {
    $teamInfo = getTeamInfo($teamID);
    $leagueInfo = getLeagueInfo($leagueID);

    $roster = getRoster($teamID, $leagueID);
    $teamName = getTeamName($teamInfo);
    $teamURI = getTeamURI($teamInfo);
    $teamImageURI = getTeamImageURI($teamInfo);
    $leagueDesc = getLeagueDescription($leagueInfo);

    unset($teamInfo, $leagueInfo);

    require dirname(__FILE__) . '/../views/roster.php';
} else {
    $msgTitle = "Bad Roster Request";
    $msg = "Your request didn't have a valid combination of teamid and leagueid.";
    $msgClass = "failure";
    require dirname(__FILE__) . '/../views/show-message.php';
}

require dirname(__FILE__) . '/end-controller.php';

