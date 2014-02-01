<?php

session_start();

require_once 'models/model.php';

if (isLoggedIn())
{
	// user is already logged in
	header('Location: index.php');
	exit(0);
}

if (isset($_POST['btnRegister']))
{
//TODO warn user if a field was missing or passwords don't match.
//TODO is an empty field ever NULL, or just an empty string?
	if ($_POST['password1'] == $_POST['password2'] && attemptRegistration($_POST['loginName'], $_POST['password1']))
	{
		$action = 'reg-success';
	}
	else
	{
//TODO check password match earlier and attemptRegistration() on its own. maybe we can get a more specific error message
		$action = 'reg-fail';
		if (strcmp($_POST['password1'], $_POST['password2']) != 0)
			$reason = 'passwords-dont-match';
		else
			$reason = 'other';
	}
}

require 'views/register.php';
