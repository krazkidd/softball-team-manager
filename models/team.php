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
//TODO sanitize $teamName (make sure it's an int)
	if (isset($teamID))
	{
		$team_query_result = runQuery("SELECT * FROM Team WHERE ID = $teamID");

        if ($team_query_result)
            return mysqli_fetch_array($team_query_result);
    }

	return NULL;
}

function getTeamManagerInfo($teamInfo)
{
    return getPlayerInfo($teamInfo['ManagerID']);
}
