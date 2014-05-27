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

$teamInfo = getTeamInfo($_GET['name']);
$teamName = $teamInfo['TeamName'];
$priColor = $teamInfo['PriColor'];
$secColor = $teamInfo['SecColor'];
$motto = $teamInfo['Motto'];
$missionStatement = $teamInfo['MissionStatement'];
$notes = '';

$mgrInfo = getTeamManagerInfo($_GET['name']);
$mgrID = $mgrInfo['ID'];
$mgrName = $mgrInfo['FirstName'] . ' ' . $mgrInfo['LastName'];

//TODO get current/past leagues
$leagues = NULL;

require 'views/team-profile.php';
