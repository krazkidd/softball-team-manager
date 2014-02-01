<?php

session_start();

require_once 'models/model.php';

//TODO save any Guest session preferences
if (isLoggedIn())
{
	// user is already logged in
	header('Location: index.php');
	exit(0);
}

if (isset($_POST['btnLogIn']))
{
//TODO i need to add some kind of timestamp or token so that this login attempt expires and can't be re-sent
	if (attemptLogin($_POST['loginName'], $_POST['password']))
	{
		$action = 'login-success';
		header('Refresh: 10; URL=/my-teams.php');
	}
	else
	{
//TODO tell user if a field was missing  (apply style to border a field with red box or something)
		$action = 'login-fail';
		if (isset($_POST['loginName']))
			$failedLoginName = $_POST['loginName'];
		else
			$failedLoginName = '';
	}
}

require 'views/login.php';
