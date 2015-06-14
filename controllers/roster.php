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

if ( !isLoggedIn())
{
	header('Location: /');
	exit(0);
}

require_once '../models/roster.php';

if (isset($_GET['id']))
{
//TODO must get other parameters
	$action = 'show-roster';
	$roster = getRoster($_GET['id']);
}
else
{
	$action = 'show-team-list';
}

require '../views/roster.php';

require 'end_controller.php';
