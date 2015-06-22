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
require_once dirname(__FILE__) . '/../models/league.php';

if (isset($id) && isID($id)) {
    $leagueID = $id;
    $leagueInfo = getLeagueInfo($leagueID);

    $leagueDesc = getLeagueDescription($leagueInfo);
    $now = time();

    $monthNum = date('m', $now); // 2-digit (i.e. 01)
    $year = date('Y', $now);     // YYYY

    //TODO this seems to be working but what page are we supposed to be linking to?
    //     we need a view for all the games on a certain date
    $qResult = runQuery("SELECT G.ID, G.DateTime FROM Game AS G JOIN League AS L ON L.ID = G.LeagueID WHERE DateTime LIKE '$year-$monthNum-%' GROUP BY DateTime ORDER BY DateTime ASC");
    $gameDays = array();
    while ($row = mysqli_fetch_array($qResult)) {
        $gameDays[] = getDayFromMySQLDate($row['DateTime']);
    }

    // get the time for the 1st of the month
    $timeOfFirstDay = mktime(0, 0, 0, $monthNum, 1, $year);

    // get full name of the month
    $monthName = date('F', $timeOfFirstDay);

    // get the day of week the 1st falls on
    // 1 (for Monday) through 7 (for Sunday)
    $dayOfWeek = date('N', $timeOfFirstDay) % 7;

    // get number of days in month
    $numDaysInMonth = date('t', $timeOfFirstDay);

    //TODO get days in previous month. PROBLEM: what if prev month is Dec? SOLUTION: just subtract 24 hours from $timeOfFirstDay
    //$numDaysInPrevMonth = date('t', mktime(0, 0, 0, $month

    unset($leagueInfo);

    require dirname(__FILE__) . '/../views/calendar.php';
} else {
    $msgTitle = "Calendar";
    $msg = "League ID required.";
    $msgClass = "failure";
    require dirname(__FILE__) . '/../views/show-message.php';
}

require dirname(__FILE__) . '/end-controller.php';

