<?php

  /**************************************************************************

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
  
  **************************************************************************/

session_start();

require_once '../models/auth.php';

doRequireNoLogin();

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
        {
			$reason = 'other';
        }
	}
}

require '../views/register.php';

require 'end_controller.php';
