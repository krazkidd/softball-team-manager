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
require_once dirname(__FILE__) . '/team.php';

function getRoster($teamID, $leagueID)
{
	$roster_query_result = runQuery("SELECT P.ID, ShirtNum, Disabled, FirstName, LastName, Gender FROM Roster AS R JOIN Player AS P ON R.PlayerID = P.ID WHERE TeamID = $teamID AND LeagueID = $leagueID ORDER BY LastName");

	if ($roster_query_result)
    {
        $result = array();
        $i = 0;
        while ($row = mysqli_fetch_array($roster_query_result))
        {
            $result[$i] = $row;
            $i++;
        }

        return $result;
    }

    return NULL;
}

function getShirtNum($playerInfo)
{
    return $playerInfo['ShirtNum'];
}

function getRosterURI($teamID, $leagueID)
{
    return "/roster?teamid=$teamID&leagueid=$leagueID";
}
