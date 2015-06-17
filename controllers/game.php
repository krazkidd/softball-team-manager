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

require_once dirname(__FILE__) . '/../models/calendar.php';
require_once dirname(__FILE__) . '/../models/game.php';
require_once dirname(__FILE__) . '/../models/team.php';

if (isset($id))
    $gameID = $id;

$gameInfo = getGameInfo($_GET['id']);
$gameTime = mktimeFromMySQLDateTime($gameInfo['DateTime']);
//TODO allow for home/away to be null and show 'TBD' or somesuch
$homeTeamInfo = getTeamInfo($gameInfo['HomeID']);
$awayTeamInfo = getTeamInfo($gameInfo['AwayID']);

$showResults = false;
if (time() > $gameTime)
    $showResults = true;

require dirname(__FILE__) . '/../views/game.php';

require dirname(__FILE__) . '/end-controller.php';
