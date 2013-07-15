<?php

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

?>
