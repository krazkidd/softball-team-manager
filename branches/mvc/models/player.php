<?php

/* *************************************************************************

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
  
************************************************************************* */

require_once 'models/model.php';

function formatPhoneNumber($phoneStr)
{
	if ($phoneStr != NULL)
	{
		if (strlen($phoneStr) == 10)
			return '(' . substr($phoneStr, 0, 3) . ') ' . substr($phoneStr, 3, 3) . '-' . substr($phoneStr, 6, 4);
		else if (strlen($phoneStr) == 7)
			return substr($phoneStr, 0, 3) . '-' . substr($phoneStr, 3, 4);
	}

	return $phoneStr;
}

function getPlayerInfo($playerID)
{
//TODO sanitize param
	$db_con = connectToDB();
	$db_query_result = mysqli_query($db_con, 'SELECT FirstName, LastName, NickName, Email, PhoneNumber, Gender FROM Player WHERE Player.ID = \'' . $playerID . '\'');

	closeDB($db_con);
	return mysqli_fetch_array($db_query_result);
}

function getPlayerTeams($playerID)
{
//TODO sanitize input!
	$db_con = connectToDB();
	$db_query_result = mysqli_query($db_con, 'SELECT P.TeamName, ParkName, DayOfWeek, SeasonDescription FROM ParticipatesIn AS P NATURAL JOIN Roster AS R WHERE R.PlayerID = \'' . $playerID . '\'');

	if ($db_query_result == NULL)
	{
		closeDB($db_con);
		return NULL;
	}

	$result = array();
	while ($row = mysqli_fetch_array($db_query_result))
	{
		$result[] = $row;
	}

	closeDB($db_con);
	return $result;
}
