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

require_once '../models/model.php';

if (!isLoggedIn())
{
	header('Location: /');
	exit(0);
}

// show all teams managed by this user
//TODO change these functions to accept manager/player ID so that the functions can be a little more generic (the controller here would pass in the logged-in user's ID)
$managedTeamsList = getUserManagedTeamNames();

$rosteredTeamsList = getUserRosteredTeamNames();

require '../views/my-teams.php';

require 'end_controller.php';
