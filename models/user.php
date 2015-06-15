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

require_once '../models/model.php';

/*
 * getUserSeasonID() -- this will return the softball season that should be
 *   used in queries to the database. There is no best default, but for now
 *   this is how the result is determined:
 *   * if the user has set a session preference, it will take priority
 *   * otherwise, if the user has a default preference (user preferences do not exist as of 
 *     19 July 2013), it will be used
 *   * otherwise, the system default will be used (see $_DEFAULTSEASON)
 *   
 *   Pages could and probably should allow another way to select the season for
 *   single queries, say, with GET and POST. I'm not sure I want to clutter the
 *   interface with a "session preferences module".  
 */
function getUserSeasonID()
{
	global $_DEFAULTSEASON;

//TODO need to standardize session preference names?
	if (isset($_SESSION['sessionPref:season']))
		return $_SESSION['sessionPref:season'];
	/*else if (isLoggedIn())
//TODO need to check the user table for this preference
		; */
	else
		return $_DEFAULTSEASON;
}

/*
 * getUserRosteredTeamNames() -- gives a list of team names
 * for which the player plays on
 */
function getRosteredTeamsForPlayer($pid)
{
	$plays_on_query_result = runQuery('SELECT T.ID, T.TeamName FROM Team AS T JOIN Roster AS R ON T.ID = R.TeamID WHERE R.PlayerID = ' . $pid);

	if ($plays_on_query_result)
	{
		$result = array();
        $i = 0;
		while($row = mysqli_fetch_array($plays_on_query_result))
		{
			$result[$i] = array('ID' => $row['ID'], 'TeamName' => $row['TeamName']);
            $i++;
		}

		return $result;
	}

	return array();
}

//TODO order by season start date--most recent first. show old seasons differently. (must JOIN with seasons, first)
//     do the same for getUserRosteredTeamNames()
function getManagedTeamsForPlayer($pid)
{
	$query_result = runQuery('SELECT ID, TeamName FROM Team WHERE ManagerID = ' . $pid);

	if ($query_result)
	{
		$result = array();
        $i = 0;
		while($row = mysqli_fetch_array($query_result))
		{
			$result[$i] = array('ID' => $row['ID'], 'TeamName' => $row['TeamName']);
            $i++;
		}

		return $result;
	}

	return array();
}

/*
 * getUserPlayerID -- get the logged-in user's player ID
 */
function getUserPlayerID()
{
	$query_result = runQuery('SELECT PlayerID FROM User WHERE Login = \'' . getLoginName() . '\'');

	if ($query_result)
	{
		$row = mysqli_fetch_array($query_result);

		return $row['PlayerID'];
	}

	return NULL;
}
