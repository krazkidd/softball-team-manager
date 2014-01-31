<?php

session_start();

require_once 'models/model.php';

// make sure user is logged in and is a manager of the specified team
//TODO if user is a manager of 
if ( !isLoggedIn() || !in_array($_GET['name'], getUserManagedTeamNames()))
{
	//header('Location: index.php');
	//exit(0);
}

if (isset($_GET['name']))
{
//TODO this doesn't check the user is a manager
	$action = 'show-team';
	$teamInfo = getTeamInfo($_GET['name']);
}
else
{
	// show all teams managed by this user
	$managedTeamsList = getUserManagedTeamNames();

	// but if they manage only one team, show it
	if (count($managedTeamsList) == 1)
	{
		$action = 'show-team';
		$teamInfo = getTeamInfo($managedTeamsList[0]);
	}
	else
		$action = 'show-list';
}

require 'views/manage.php';
