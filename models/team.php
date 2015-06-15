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

require_once 'model.php';

function getTeamInfo($teamID)
{
//TODO sanitize $teamName (make sure it's an int)
	if (isset($teamID))
	{
		$team_query_result = runQuery("SELECT ID, TeamName, PriColor, SecColor, Motto, MissionStatement FROM Team WHERE ID = $teamID");

//DEBUG
//TODO do better error handling here
        if ( !$team_query_result || mysqli_num_rows($team_query_result) == 0)
            error_log('No info was found for team \''. $escapedTeamName . '\' in the database.');
//END DEBUG

		$teamInfo = mysqli_fetch_array($team_query_result);

        return $teamInfo;
	}

	return NULL;
}

function getTeamManagerInfo($teamID)
{
	$mgr_query_result = runQuery("SELECT ManagerID, FirstName, LastName FROM Player AS P JOIN Team AS T ON P.ID = T.ManagerID WHERE T.ID = $teamID");

	if ( !$mgr_query_result)
	{
		error_log('No manager was found for team \''. $teamID . '\' in the database. (This is a "feature", not really an error/bug.');
		return NULL;
	}

	return mysqli_fetch_array($mgr_query_result);
}
