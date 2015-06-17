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

require_once dirname(__FILE__) . '/../models/player.php';

$playerInfo = getPlayerInfo($_GET['id']);
//TODO if $playerInfo is NULL, then use an $action to show a query failure message

$firstName = $playerInfo['FirstName'];
$lastName = $playerInfo['LastName'];
$nickName = $playerInfo['NickName'];
$phone = $playerInfo['PhoneNumber'] ? formatPhoneNumber($playerInfo['PhoneNumber']) : '[Not Specified]';
$email = $playerInfo['Email'] ? '<a href="mailto:' . $playerInfo['Email'] . '">' . $playerInfo['Email'] . '</a>' : '[Not Specified]';
$gender = $playerInfo['Gender'] ? $playerInfo['Gender'] : '[Not Specified]';

//TODO query DB for teams for teams this player manages or plays on and list them
$teams = getPlayerTeams($_GET['id']);

require dirname(__FILE__) . '/../views/player.php';

require dirname(__FILE__) . '/end-controller.php';
