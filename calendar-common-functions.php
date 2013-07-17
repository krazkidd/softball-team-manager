<?php

require_once("common-functions.php");

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

function displayCalendar($month, $year)
{
//TODO make sure month and year are valid (even go so far as to check db?)
	$db_con = connectToDB();
	
//TODO select ALL games for a team, or just for one league, depending on user preference
//TODO will MySQL understand if month doesn't have leading zeros? NOPE.
	$gameList = mysqli_query($db_con, "SELECT date FROM games JOIN leagues ON associatedLeague = leagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE games.date LIKE '$year-$month-%' GROUP BY date ORDER BY date");

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

	// print the calendar table
?>
			<table>
				<tr>
					<th colspan="7"><?= $monthName ?> <?= $year ?></th>
				</tr>
				<tr>
					<td><a href="calendar.php?view=daily&amp;day=sun">Sun</a></td>
					<td><a href="calendar.php?view=daily&amp;day=mon">Mon</a></td>
					<td><a href="calendar.php?view=daily&amp;day=tue">Tue</a></td>
					<td><a href="calendar.php?view=daily&amp;day=wed">Wed</a></td>
					<td><a href="calendar.php?view=daily&amp;day=thu">Thu</a></td>
					<td><a href="calendar.php?view=daily&amp;day=fri">Fri</a></td>
					<td><a href="calendar.php?view=daily&amp;day=sat">Sat</a></td>
				</tr>
				<tr>
<?php
	// keep track of the day of the week
	$weeklyDayCount = 1;
	// print blank days
	while ($numBlankDays > 0)
	{
?>
					<td>&nbsp;</td>
<?php
		$numBlankDays--;
		$weeklyDayCount++;
	}

	// print the days of the month
	$monthlyDayCount = 1;
//TODO need to check that this is not null!
	$gameRow = mysqli_fetch_array($gameList);
	while ($monthlyDayCount <= $numDaysInMonth)
	{
		$gameDate = NULL;
		$elementClass = NULL;

		// if there is/was a game on this date, link to it and set the next game date to check for
		if ($monthlyDayCount == getDayFromMySQLDate($gameRow['date']))
		{
			$elementClass = "gameday";
			$gameDate = $gameRow['date'];
			$gameRow = mysqli_fetch_array($gameList);
		}
		// but if the date has already passed, don't put a cute image
		if (mktime(0, 0, 0, $month, $monthlyDayCount + 1, $year) < time())
			$elementClass = "calDatePassed";
		else if ($monthlyDayCount == date("d"))
			$elementClass = "todays-date"

//TODO how do I want the date to show in the URL (i.e. with or without dashes?), and do dashes need to be escaped?
?>
					<td<?= $elementClass != NULL ? " class=\"$elementClass\"" : "" ?>><?= $gameDate != NULL ? "<a href=\"calendar.php?date={$gameDate}\">$monthlyDayCount</a>" : $monthlyDayCount ?></td>
<?php		
		$monthlyDayCount++;
		
		$weeklyDayCount++;
		if ($weeklyDayCount > 7)
		{
?>
				</tr>
				<tr>
<?php
			$weeklyDayCount = 1;
		}
	}

	while ($weeklyDayCount <= 7)
	{
?>
					<td>&nbsp;</td>
<?php
		$weeklyDayCount++;
	}

?>
				</tr>
			</table>
<?php
}

?>

