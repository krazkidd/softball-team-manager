<?php

require_once 'models/model.php';

function getHourFromMySQLTime($timeString)
{
	return substr($timeString, 0, 2);
}
function getMinuteFromMySQLTime($timeString)
{
	return substr($timeString, 3, 2);
}
function getYearFromMySQLDate($dateString)
{
	return substr($dateString, 0, 4);
}
function getMonthFromMySQLDate($dateString)
{
	return substr($dateString, 5, 2);
}
function getDayFromMySQLDate($dateString)
{
//TODO check for NULL argument?
	return substr($dateString, 8, 2);
}

//TODO add second parameter for date?
function mktimeFromMySQLTime($timeString)
{
	return mktime(getHourFromMySQLTime($timeString), getMinuteFromMySQLTime($timeString));
}

function getLeaguesThatPlayOnDayOfWeek($day)
{
	switch (strtolower(substr($day)))
	{
		case 'sun':
		case 'mon':
		case 'tue':
		case 'wed':
		case 'thu':
		case 'fri':
		case 'sat':
			$day = ucwords(strtolower(substr($_GET['day'], 0, 3)));
			break;
		default:
			error_log('Bad value for day of week was provided: \'' . $day . '\'');
			return NULL;
	}

	$db_con = connectToDB();

//TODO fix query!
	$db_query_result = mysqli_query($db_con, "SELECT * FROM leagues JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE leagues.dayOfWeek = '$day' ORDER BY startDate DESC");

	$result = array();
	while ($row = mysqli_fetch_array($db_query_result)
	{
		$result[] = $row;
	}

	return $result;
}

function getGamesByDate($dateStr)
{
//TODO make sure date argument is in proper format
	$db_con = connectToDB();
//TODO fix query
	$db_game_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE date = '{$_GET['date']}' ORDER BY time");

	if ($db_game_info_query_result == NULL)
	{
		error_log('The game info query result was NULL');
	}

	$result = array();
	while ($row = mysqli_fetch_array($db_game_info_query_result))
	{
		$result[] = $row;
	}

	return $result;
}

function RENAME_THIS($month, $year)
{
	// make sure month and year are valid
	if ( !is_int($month) || !is_int($year) || !checkdate($month, 1, $year))
		return NULL;

	$month = sprintf('%02d', $month);

	$db_con = connectToDB();
	
//TODO need to check that this is not null!
//TODO this is grabbing all games for all teams...
	$gameList = mysqli_query($db_con, "SELECT DateTime FROM Game AS G NATURAL JOIN League AS L JOIN Season AS S ON S.Description = L.SeasonDescription WHERE DateTime LIKE '$year-$month-%' GROUP BY DateTime ORDER BY DateTime");

	// get the time for the 1st of the month
	$timeOfFirstDay = mktime(0, 0, 0, $month, 1, $year);

	// get name of the month
	$monthName = date('F', $timeOfFirstDay);

	// get the day of week the 1st falls on
	$dayOfWeek = date('D', $timeOfFirstDay);

	// how many blank days to draw in calendar grid before the 1st
	switch($dayOfWeek)
	{
		case 'Sun':
			$numBlankDays = 0;
			break;
		case 'Mon':
			$numBlankDays = 1;
			break;
		case 'Tue':
			$numBlankDays = 2;
			break;
		case 'Wed':
			$numBlankDays = 3;
			break;
		case 'Thu':
			$numBlankDays = 4;
			break;
		case 'Fri':
			$numBlankDays = 5;
			break;
		default:
			$numBlankDays = 6;
	}

	// get number of days in month
	$numDaysInMonth = date('t', $timeOfFirstDay);
//TODO get days in previous month. PROBLEM: what if prev month is Dec? SOLUTION: just subtract 24 hours from $timeOfFirstDay
	//$numDaysInPrevMonth = date('t', mktime(0, 0, 0, $month

	// keep track of the day of the week
	$weeklyDayCount = 1;
	// print blank days
	while ($numBlankDays > 0)
	{
		$numBlankDays--;
		$weeklyDayCount++;
	}

	// print the days of the month
	$monthlyDayCount = 1;
	$gameRow = mysqli_fetch_array($gameList);
	while ($monthlyDayCount <= $numDaysInMonth)
	{
		$gameDate = NULL;
		$elementClass = NULL;

		// if there is/was a game on this date, link to it and set the next game date to check for
		if ($monthlyDayCount == getDayFromMySQLDate($gameRow['date']))
		{
			$elementClass = 'gameday';
			$gameDate = $gameRow['date'];
			$gameRow = mysqli_fetch_array($gameList);
		}
//TODO check for roster freeze date (use a border style and *append* the class so i doesn't conflict with another, except it should override the style for today's date)
		// but if the date has already passed, don't put a cute image
		if (mktime(0, 0, 0, $month, $monthlyDayCount + 1, $year) < time())
			$elementClass = 'calDatePassed';
		else if ($monthlyDayCount == date('d'))
			$elementClass = 'todays-date'
		$monthlyDayCount++;
		
		$weeklyDayCount++;
		if ($weeklyDayCount > 7)
		{
			$weeklyDayCount = 1;
		}
	}

	while ($weeklyDayCount <= 7)
	{
		$weeklyDayCount++;
	}

FIX
	return NULL;
}
