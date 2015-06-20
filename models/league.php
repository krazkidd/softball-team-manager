
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

require_once dirname(__FILE__) . '/model.php';

function getLeagueInfo($leagueID)
{
	return mysqli_fetch_array(runQuery("SELECT L.*, C.Name FROM League AS L JOIN Class AS C ON L.ClassID = C.ID WHERE L.ID = $leagueID"));
}

function getLeagueDescription($leagueInfo)
{
    return $leagueInfo['Description'] . ' (' . getLeagueClass($leagueInfo) . ')';
}

function getLeagueClass($leagueInfo)
{
    return $leagueInfo['Name'];
}
