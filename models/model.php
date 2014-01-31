<?php

//TODO because this file is included, this path is relative to wherever this is included from. Add a SITE_URL to config.php
require 'config/config.php';

/*
 * connectToDB() -- Tries to connect to the database
 *
 * Returns: A mysqli object that represents a connection to a MySQL DB
 */
function connectToDB()
{
	global $_DBHOST;
	global $_DBUSER;
	global $_DBPASS;
	global $_DBNAME;

	// create db connection
	$db_con = mysqli_connect($_DBHOST, $_DBUSER, $_DBPASS, $_DBNAME);
//DEBUG
if ( !$db_con)
	error_log('Database connection error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
//END DEBUG

	return $db_con;
}

function closeDB($db_con)
{
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
//TODO don't allow a loginname like "Guest", or use NULL here
		return 'Guest';
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
	$db_con = connectToDB();

	$query_result = mysqli_query($db_con, 'SELECT PlayerID FROM User WHERE Login = \'' . getLoginName() . '\'');

	if ($query_result)
	{
		$row = mysqli_fetch_array($query_result);

//TODO can I close the DB before myqsqli_fetch_array? surely not if results are buffered, but maybe here it's okay
		closeDB($db_con);
		return $row['PlayerID'];
	}

	closeDB($db_con);
	return NULL;
}

//TODO order by season start date--most recent first. show old seasons differently. (must JOIN with seasons, first)
//     do the same for getUserRosteredTeamNames()
function getUserManagedTeamNames()
{
	$db_con = connectToDB();

	$query_result = mysqli_query($db_con, 'SELECT TeamName FROM Team AS T JOIN Player AS P ON T.ManagerID = P.ID JOIN User AS U ON P.ID = U.PlayerID WHERE Login = \'' . getLoginName() . '\'');

	if ($query_result)
	{
		$result = array();
		while($row = mysqli_fetch_array($query_result))
		{
			$result[] = $row['TeamName'];
		}

//TODO can I close the DB before myqsqli_fetch_array? surely not if results are buffered, but maybe here it's okay
		closeDB($db_con);
		return $result;
	}

	closeDB($db_con);
	return array();
}

/*
 * getUserRosteredTeamNames() -- gives a list of team names
 * for which the player plays on
 */
function getUserRosteredTeamNames()
{
	$db_con = connectToDB();

	$plays_on_query_result = mysqli_query($db_con, 'SELECT R.TeamName FROM Roster AS R JOIN Team AS T ON R.TeamName = T.TeamName WHERE PlayerID = \'' . getUserPlayerID() .'\'');

	if ($query_result)
	{
		$result = array();
		while($row = mysqli_fetch_array($query_result))
		{
			$result[] = $row['TeamName'];
		}

//TODO can I close the DB before myqsqli_fetch_array? surely not if results are buffered, but maybe here it's okay
		closeDB($db_con);
		return $result;
	}

	closeDB($db_con);
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


function getTeamInfo($teamName)
{
//TODO sanitize $teamName
	$db_con = connectToDB();

	if (isset($teamName))
	{
		$escapedTeamName = mysqli_real_escape_string($db_con, $teamName);
		$team_query_result = mysqli_query($db_con, "SELECT TeamName, PriColor, SecColor, Motto FROM Team WHERE TeamName = '$escapedTeamName'");
//DEBUG
//TODO do better error handling here
if ( !$team_query_result || mysqli_num_rows($team_query_result) == 0)
	error_log('No info was found for team \''. $escapedTeamName . '\' in the database.');
//END DEBUG

		$teamInfo = mysqli_fetch_array($team_query_result);
	}

	closeDB($db_con);
	return $teamInfo;
}
