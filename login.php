<?php

/* *************************************************************************

  This file is part of Team Manager.

  Copyright © 2013 Mark Ross <krazkidd@gmail.com>

  Team Manager is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  Team Manager is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with Team Manager.  If not, see <http://www.gnu.org/licenses/>.
  
************************************************************************* */

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
