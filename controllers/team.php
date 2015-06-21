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
require_once dirname(__FILE__) . '/../models/team.php';
require_once dirname(__FILE__) . '/../models/league.php';

if (isset($id) && isID($id)) {
    $isLoggedIn = isLoggedIn();
    $teamInfo = getTeamInfo($id);
    $mgrInfo = getTeamManagerInfo($teamInfo);

    $teamName = getTeamName($teamInfo);
    $teamImageURI = getTeamImageURI($teamInfo);
    $priColor = getPrimaryColor($teamInfo);
    $secColor = getSecondaryColor($teamInfo);
    $motto = getTeamMotto($teamInfo);
    $missionStatement = getMissionStatement($teamInfo);
    //TODO notes not used
    //$notes = getNotes($teamInfo);
    $leagueList = getLeaguesForTeam($teamInfo);
    if ($mgrInfo) {
        $mgrURI = getPlayerURI($mgrInfo);
        $mgrName = getFullName($mgrInfo);
    }

    unset($teamInfo, $mgrInfo);

    require dirname(__FILE__) . '/../views/team.php';
} else {
        $msgTitle = "Team";
        $msg = "Not a valid team ID.";
        $msgClass = "failure";
        require dirname(__FILE__) . '/../views/show-message.php';
}

require dirname(__FILE__) . '/end-controller.php';

