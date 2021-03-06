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

require_once dirname(__FILE__) . '/../models/model.php';

//TODO are array indexes case-sensitive? YES. so we need to write a controller class
//     to at least handle url parameters
if (isset($_GET['id']) && isID($_GET['id']))
    $id = $_GET['id'];

if (isset($_GET['teamid']) && isID($_GET['teamid']))
    $teamID = $_GET['teamid'];

if (isset($_GET['gameid']) && isID($_GET['gameid']))
    $gameID = $_GET['gameid'];

if (isset($_GET['leagueid']) && isID($_GET['leagueid']))
    $leagueID = $_GET['leagueid'];

//TODO get other url params here instead of other controller files

