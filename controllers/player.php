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

if (isset($id)) {
    $playerInfo = getPlayerInfo($id);

    if ($playerInfo) {
        $name = getFullName($playerInfo);
        $firstName = getFirstName($playerInfo);
        $nickName = getNickName($playerInfo);
        //TODO only show this stuff to the player's managers
        $phone = getFormattedPhoneNumber($playerInfo);
        $email = getEmail($playerInfo);
        $gender = getGender($playerInfo, false);
        $teams = getRosteredTeamsForPlayer($id);

        unset($playerInfo);

        require dirname(__FILE__) . '/../views/player.php';
    }
} else {
    $msgTitle = "Player";
    $msg = "Not a valid player id.";
    $msgClass = "failure";
    require dirname(__FILE__) . '/../views/show-message.php';
}

require dirname(__FILE__) . '/end-controller.php';

