<?php

$_DEFAULTSEASON = 1;

/* database access vars */
$_DBHOST = 'localhost';
$_DBUSER = 'team_mgrAdmin';
$_DBPASS = 'chumbawumba';
$_DBPREFIX = '';
$_DBNAME = $_DBPREFIX . 'team_mgr';

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

?>
