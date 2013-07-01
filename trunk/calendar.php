
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
	echo "<table>\n<tr><th colspan=\"7\">$monthName $yearPart</th></tr>\n";
	echo "<tr><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>\n";

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
//TODO this gameday check below will change when i decide what to link to in the calendar
		if ($weeklyDayCount == 2 || $weeklyDayCount == 4)
			echo "<td class=\"gameday\">$monthlyDayCount</td>";
		else
			echo "<td>$monthlyDayCount</td>";
		
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
		

?>
		</div> <!-- calendar -->

	</body>
</html>
