
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show some more info in title -->
	<title>Calendar</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="calendar-body">
		<div id="calendar-header">
			<h1>Calendar</h1>
		</div>

		<div id="calendar">
<?php
//TODO by default, show everything for the logged-in user. but check GET or POST for a particular season/league/team(/game?)

	if (isset($_GET['view']) && $_GET['view'] == 'daily' && isset($_GET['day']))
	{
//TODO delete this line below when this page is prettified
echo "<p class=\"error\">This still needs some work.</p>";
		// show leagues that play on selected day
		switch (substr(strtolower($_GET['day']), 0, 3))
		{
			case 'sun':
				$day = 'Sun';
				break;
			case 'mon':
				$day = 'Mon';
				break;
			case 'tue':
				$day = 'Tue';
				break;
			case 'wed':
				$day = 'Wed';
				break;
			case 'thu':
				$day = 'Thu';
				break;
			case 'fri':
				$day = 'Fri';
				break;
			case 'sat':
				$day = 'Sat';
				break;
			default:
				echo "<p>There was an error in your request. Click <a href=\"calendar.php\">here</a> to go to the Calendar page.</p>";
				echo "</div></body></html>";
				exit();
		}

		// create db connection
		$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs");
		// check for success
		if (mysqli_connect_errno($db_con))
		{
			echo "<p class=\"db-error\">Connection error (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
			exit();
		}

		$db_query_result = mysqli_query($db_con, "SELECT * FROM leagues JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE leagues.dayOfWeek = '$day'");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

		// print a table that shows leagues that play on that day of the week
//TODO add a colspan to this table
		echo "<h2>$day Leagues</h2>";
//TODO add the table header columns. I got real lazy here
		echo "<table><tr><th>table header here</th></tr>";
		// iterate through each row of the result
		while ($row = mysqli_fetch_array($db_query_result))
		{
//TODO add a link to league info (i think i don't have a league info page yet)
//TODO add the other columns retrieved in query above. I'm REALLY lazy now.
			echo "<tr><td>{$row['division']}</td><td>{$row['class']}</td></tr>";
		}
		echo "</table>";

//TODO Do I really *not* have to close the connection?
		mysqli_close($db_con);
	}
	else
	{
		// print this month's calendar
		$currentDate = time();

		$dayPart = date('d', $currentDate);
		$monthPart = date('m', $currentDate);
		$yearPart = date('Y', $currentDate);

		// get the 1st of the month
		$firstDay = mktime(0, 0, 0, $monthPart, 1, $yearPart);

		// get name of month
		$monthName = date('F', $firstDay);

		// get the day of week the 1st falls on
		$dayOfWeek = date('D', $firstDay);

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
		$numDaysInMonth = date('t', $currentDate);
//TODO print days in previous month. PROBLEM: what if prev month is Dec?
		//$numDaysInPrevMonth = date('t', mktime(0, 0, 0, $month

//TODO what do I want to link to in the calendar? should every day be a link to a search for games on that date? or should i only link to games on that date? because i don't want to do 30 queries...right? (if ever day is a link, highlight days with games.) or i can link only game days (but that hardly stops the queries unless I save them in an array...which is exactly what i do...)

		// print the calendar
		echo "<table>\n<tr><th colspan=\"7\">$monthName $yearPart</th></tr>\n<tr>";
		echo "<td><a href=\"calendar.php?view=daily&day=sun\">Sun</a></td>";
		echo "<td><a href=\"calendar.php?view=daily&day=mon\">Mon</a></td>";
		echo "<td><a href=\"calendar.php?view=daily&day=tue\">Tue</a></td>";
		echo "<td><a href=\"calendar.php?view=daily&day=wed\">Wed</a></td>";
		echo "<td><a href=\"calendar.php?view=daily&day=thu\">Thu</a></td>";
		echo "<td><a href=\"calendar.php?view=daily&day=fri\">Fri</a></td>";
		echo "<td><a href=\"calendar.php?view=daily&day=sat\">Sat</a></td>";
		echo "</tr>\n";

		echo "<tr>";

		// keep track of the day of the week
		$weeklyDayCount = 1;
		// print blank days
		while ($numBlankDays > 0)
		{
			echo "<td>&nbsp;</td>";
			$numBlankDays--;
			$weeklyDayCount++;
		}

		// keep track of the day of the month
		$monthlyDayCount = 1;
		while ($monthlyDayCount <= $numDaysInMonth)
		{
//TODO this gameday check below will have to change when i decide what to link to in the calendar
//TODO the check for past dates will need a change when I allow different months to be viewed
			$elementClass = '';
			if ($weeklyDayCount == 2 || $weeklyDayCount == 4)
				$elementClass = "gameday";
//TODO yes this check here is redundant...but only until I allow different months to be displayed
			if ($yearPart <= date('Y') && $monthPart <= date('m') && $monthlyDayCount < date('d'))
				$elementClass = $elementClass . " calDatePassed";

//TODO is it okay to have the class attribute if it's empty?
			echo "<td class=\"{$elementClass}\">{$monthlyDayCount}</td>";
			
			$monthlyDayCount++;
			
			$weeklyDayCount++;
			if ($weeklyDayCount > 7)
			{
				echo "</tr>\n<tr>";
				$weeklyDayCount = 1;
			}
		}

		while ($weeklyDayCount <= 7)
		{
			echo "<td>&nbsp;</td>";
			$weeklyDayCount++;
		}

		// close table
		echo "</tr>\n</table>";
	}
		

?>
		</div> <!-- calendar -->

	</body>
</html>
