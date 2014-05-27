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
require_once 'models/calendar.php';

//TODO when no team is given, don't show all games in cal. ask user to select region/season/league
//TODO by default, show everything for the logged-in user. but check GET or POST for a particular season/league/team(/game?)

// show all leagues that play on a certain day of the week when the user clicks on the day header
if (isset($_GET['view']) && $_GET['view'] == 'daily' && isset($_GET['day']))
{
	// show leagues that play on selected day
	$action = 'list-leagues-day-of-week';
	$day = ucwords(strtolower($_GET['day']));
	$leaguesList = getLeaguesThatPlayOnDayOfWeek($_GET['day']);
}
else if (isset($_GET['date']))
{
	$action = 'list-games-on-date';
	$date = NULL;
//TODO make sure to grab game scores when getting games list
//TODO check to see if the scores are NULL and output something appropriate (because I show the score columns before all games have finished)
	$gamesList = NULL;
//TODO when to show results columns? (game time + 1 hr.?) -->
//TODO i guess there might be a problem comparing time and mktime values. see gmmktime doc page -->
	if (time() > mktime(getHourFromMySQLTime($row['time']) + 1, getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date'])))
		$showResults = false;
	else
		$showResults = true;
//TODO get team info (add function or use one I already have
//TODO
//TODO
//TODO
	// get team info
	//$homeTeamRow = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM teams WHERE teamID = {$row['homeTeam']}"));
	//$awayTeamRow = mysqli_fetch_array(mysqli_query($db_con, "SELECT * FROM teams WHERE teamID = {$row['visitingTeam']}"));
}
else
//TODO fix this block!
{
//TODO make a 2-d array for the month with date and game info
	if (isset($_GET['mo']))
	{
		$month = $_GET['mo'];
		if (isset($_GET['yr']))
			$year = $_GET['yr'];
		else
			$year = date('Y');
	}
	else
	{
		$month = date('m');
		$year = date('Y');
	}

	$calendarArray = RENAME_THIS($month, $year);
	$action = 'show-month';
}

require 'views/calendar.php';
