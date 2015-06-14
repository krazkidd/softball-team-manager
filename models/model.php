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

require_once '../config/config.php';

//TODO this block needs to be tested
if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION < 5)
{
    if ( !file_exists('../models/password.php'))
        exit("The password_compat library is required for this version of PHP but it cannot be found in the models/ directory.");

    require_once '../models/password.php';
}

$db_con = NULL;

function runQuery($queryStr)
{
    global $db_con;

    if ($db_con == NULL)
    {
        $db_con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//DEBUG
        //echo 'Making new connection...';
//END DEBUG
    }

    $result = NULL;

    if ($db_con)
    {
        //TODO can I/should I escape all query strings here and not worry about it elsewhere?
	    $result = mysqli_query($db_con, $queryStr);
    }
//DEBUG
    else
        error_log('Database connection error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
//END DEBUG

    return $result;
}

function closeDB()
{
    global $db_con;

    if ($db_con == NULL)
        return false;

	return mysqli_close($db_con);
}

function isLoggedIn()
{
	return isset($_SESSION['loginname']);
}

function getLoginName()
{
	if (isLoggedIn())
		return $_SESSION['loginname'];
	else
		return '';
}

function getUserName()
{
	return getLoginName();
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

//TODO order by season start date--most recent first. show old seasons differently. (must JOIN with seasons, first)
//     do the same for getUserRosteredTeamNames()
function getUserManagedTeamNames()
{
	$query_result = runQuery('SELECT ID, TeamName FROM Team WHERE ManagerID = ' . getUserPlayerID());

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
 * getUserRosteredTeamNames() -- gives a list of team names
 * for which the player plays on
 */
function getUserRosteredTeamNames()
{
	$plays_on_query_result = runQuery('SELECT T.ID, T.TeamName FROM Team AS T JOIN Roster AS R ON T.ID = R.TeamID WHERE R.PlayerID = ' . getUserPlayerID());

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

function attemptLogin($username, $password)
{
//TODO sanitize input
	if ($username && !empty($username) && $password && !empty($password))

	$ret = runQuery('SELECT PasswordHash FROM `User` WHERE Login = \'' . $username . '\'');

	$result = mysqli_fetch_array($ret)['PasswordHash'];

	if ($ret)
	{
		if (password_verify($password, $result))
		{
			// save login name to session
			$_SESSION['loginname'] = $username;

			return True;
		}
	}

	return False;
}

function attemptRegistration($loginName, $password)
{
//TODO don't allow blank password. do some basic password enforcement
//TODO sanitize input. also don't allow only differences in case or spacing for login names
	if ($loginName && strlen($loginName) >= 3
	    && $password && strlen($password) >= 6)
	{
		$ret = runQuery('INSERT INTO `User` VALUES (NULL, \'' . $loginName . '\', \'' . password_hash($password, PASSWORD_DEFAULT) . '\', NULL)');

		if ($ret)
		{
			// save login name to session
			$_SESSION['loginname'] = $loginName;

			return TRUE;
		}
		else
			error_log('Could not register user \'' . $loginName . '\'. (Could not INSERT into User table.)');
	}

	return FALSE;
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
