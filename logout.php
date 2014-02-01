<?php

session_start();

require_once 'models/model.php';

if ( !isLoggedIn())
{
	// user not logged in, redirect to Home page
	header('Location: index.php');
	exit(0);
}

$_SESSION = array(); // or session_unset()
session_destroy();

$action = 'logout-success';

require 'views/logout.php';
