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
// check for success
if (mysqli_connect_errno())
	echo "<p class=\"db-error\">Database connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
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

//TODO right now this is just returning a placeholder value. I may not need it at all because what I need is a way to associate all teams under a certain user/manager, and that could be accomplished by adding a manager column to the teams table
//TODO change "User" in function name to "Login" like other functions?
function getUserTeamName()
{
//TODO this should get the team name for the team *ID* associated with the user. and that ID should be changeable by the user, like if they manage multiple teams
	return 'Oddballs';
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
