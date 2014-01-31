<?php

session_start();

require_once 'models/model.php';

if (!isLoggedIn())
{
	header('Location: index.php');
	exit(0);
}

// show all teams managed by this user
//TODO change these functions to accept manager/player ID so that the functions can be a little more generic (the controller here would pass in the logged-in user's ID)
$managedTeamsList = getUserManagedTeamNames();

$rosteredTeamsList = getUserRosteredTeamNames();

require 'views/my-teams.php';
