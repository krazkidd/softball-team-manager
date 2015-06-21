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

if (isset($id)) {
    $gameInfo = getGameInfo($id);
    $gameTime = mktimeFromMySQLDateTime($gameInfo['DateTime']);
    //TODO allow for home/away to be null and show 'TBD' or somesuch
    //TODO show W/L (in parentheses next to Away/Home)
    //TODO show if there was a forfeit
    $homeInfo = getHomeTeamInfo($gameInfo);
    $awayInfo = getAwayTeamInfo($gameInfo);
    $homeScore = getHomeTeamScore($gameInfo);
    $awayScore = getAwayTeamScore($gameInfo);
    $homePriColor = getPrimaryColor($homeInfo);
    $homeSecColor = getSecondaryColor($homeInfo);
    $awayPriColor = getPrimaryColor($awayInfo);
    $awaySecColor = getSecondaryColor($awayInfo);
    if ($homeScore > $awayScore) {
        $winColor =  $homeSecColor;
    } elseif ($awayScore > $homeScore) {
        $winColor =  $awaySecColor;
    }

    // just in case a game can end in a tie, show scores after game has been played
    $showResults = ($homeScore > 0 || $awayScore > 0) || time() > $gameTime;

    require dirname(__FILE__) . '/../views/game.php';
} else {
    $msgTitle = "Bad Game Request";
    $msg = "Not a valid gameid.";
    $msgClass = "failure";
    require dirname(__FILE__) . '/../views/show-message.php';
}

require dirname(__FILE__) . '/end-controller.php';

