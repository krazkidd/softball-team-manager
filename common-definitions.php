<?php

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

?>
