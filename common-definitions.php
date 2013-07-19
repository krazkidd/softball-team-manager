<?php
//TODO use a persistent/global db connection

$_DEFAULTSEASON = 1;

/* database access vars */
$_DBHOST = "localhost";
$_DBUSER = "OddAdmin";
$_DBPASS = "OddPass";
$_DBPREFIX = "";
$_DBTABLE = $_DBPREFIX . "oddballs";

/*
 * connectToDB() -- Tries to connect to the database
 */
function connectToDB()
{
	global $_DBHOST;
	global $_DBUSER;
	global $_DBPASS;
	global $_DBTABLE;

	// create db connection
//TODO this info should be outside the web root and be user-configurable, like WordPress/Joomla!
	$db_con = mysqli_connect($_DBHOST, $_DBUSER, $_DBPASS, $_DBTABLE);
	// check for success
	if (mysqli_connect_errno())
	{
		echo "<p class=\"db-error\">Database connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
//TODO this should not exit() but rather be handled by the caller
		exit();
	}

	return $db_con;
}

function closeDB($db_con)
{
	return mysqli_close($db_con);
}

function isLoggedIn()
{
//TODO find a better way to check the user has logged in (if i am going to allow guests to have sessions, this might actually return true for them, if I decide to use this particular session var to store a guest "name")
	return isset($_SESSION["username"]);
}

//TODO change this to getLoginName? I want to associate login names to player names and "user" is somewhat ambiguous
function getUserName()
{
	if (isLoggedIn())
		return $_SESSION["username"];
	else
//TODO don't allow a username like "Guest", or use NULL here
		return "Guest";
}

//TODO right now this is just returning a placeholder value. I may not need it at all because what I need is a way to associate all teams under a certain user/manager, and that could be accomplished by adding a manager column to the teams table
function getUserTeamName()
{
	return "Oddballs";
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
	if (isset($_SESSION["sessionPref:season"]))
		return $_SESSION["sessionPref:season"];
	/*else if (isLoggedIn())
//TODO need to check the user table for this preference
		; */
	else
		return $_DEFAULTSEASON;
}

?>
