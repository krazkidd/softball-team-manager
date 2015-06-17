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

require dirname(__FILE__) . '/begin-controller.php';

require_once dirname(__FILE__) . '/../models/auth.php';

doRequireLogin();

require_once dirname(__FILE__) . '/../models/team.php';

//TODO make sure user is manager of the specified team

if (isset($id))
    $teamID = $id;
else
    $teamID = 0;

if ($teamID > 0)
{
//TODO this doesn't check the user is a manager
	$action = 'show-team';
	$teamInfo = getTeamInfo($_GET['id']);
}
else
{
	// show all teams managed by this user
    $action = 'show-list';
	$managedTeamsList = getUserManagedTeamNames();
}

require dirname(__FILE__) . '/../views/manage.php';

require dirname(__FILE__) . '/end-controller.php';
