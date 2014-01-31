<?php

session_start();

require_once 'models/model.php';

// make sure user is logged in and is a manager of the specified team
if ( !isLoggedIn() || !in_array($_GET['name'], getUserManagedTeamNames()))
{
	//header('Location: index.php');
	//exit(0);
}

if (isset($_GET['name']))
{
	$action = 'show-team';
	$teamInfo = getTeamInfo($_GET['name']);
}
else
{
	$action = 'show-list';
	$managedTeamsList = getUserManagedTeamNames();
}

require 'views/manage.php';
