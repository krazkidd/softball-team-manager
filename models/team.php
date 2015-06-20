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
require_once dirname(__FILE__) . '/player.php';

function getTeamInfo($teamID)
{
    if (is_int($teamID + 0))
    {
        $qResult = runQuery("SELECT * FROM Team WHERE ID = $teamID");

        if ($qResult)
            return mysqli_fetch_array($qResult);
    }

    return null;
}

function getTeamManagerInfo($teamInfo)
{
    if ($teamInfo)
        return getPlayerInfo($teamInfo['ManagerID']);

    return null;
}

function getPrimaryColor($teamInfo)
{
    if ($teamInfo)
        return $teamInfo['PriColor'];

    return '000000';
}

function getSecondaryColor($teamInfo)
{
    if ($teamInfo)
        return $teamInfo['SecColor'];

    return 'ffffff';
}

function getTeamName($teamInfo)
{
    if ($teamInfo)
        return $teamInfo['TeamName'];

    return '';
}

function getTeamURI($teamInfo)
{
    if ($teamInfo)
        return "/team/{$teamInfo['ID']}";

    return '#';
}

function getManageURI($teamInfo)
{
    if ($teamInfo)
        return "/manage/{$teamInfo['ID']}";

    return '#';
}

function getTeamMotto($teamInfo)
{
    if ($teamInfo)
        return $teamInfo['Motto'];

    return '';
}

function getMissionStatement($teamInfo)
{
    if ($teamInfo)
        return $teamInfo['MissionStatement'];

    return '';
}

function getNotes($teamInfo)
{
    if ($teamInfo)
        return $teamInfo['Notes'];

    return '';
}

function getTeamImageURI($teamInfo)
{
    if ($teamInfo)
        return '/img/team-no-image.png';

    return '/img/team-no-image.png';
}
