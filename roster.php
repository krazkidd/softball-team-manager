<?php

session_start();

require_once 'models/model.php';

if (!isLoggedIn())
{
	header('Location: index.php');
	exit(0);
}

require_once 'models/roster.php';

if (isset($_GET['name']))
{
//TODO must get other parameters
	$action = 'show-roster';
	$roster = getRoster($_GET['name']);
}
else
{
	$action = 'show-team-list';
}

require 'views/roster.php';
