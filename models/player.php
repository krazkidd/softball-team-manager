<?php

require_once 'models/model.php';

function formatPhoneNumber($phoneStr)
{
	if ($phoneStr != NULL)
	{
		if (strlen($phoneStr) == 10)
			return '(' . substr($phoneStr, 0, 3) . ') ' . substr($phoneStr, 3, 3) . '-' . substr($phoneStr, 6, 4);
		else if (strlen($phoneStr) == 7)
			return substr($phoneStr, 0, 3) . '-' . substr($phoneStr, 3, 4);
	}

	return $phoneStr;
}

function getPlayerInfo($playerID)
{
//TODO sanitize param
	$db_con = connectToDB();
	$db_query_result = mysqli_query($db_con, 'SELECT FirstName, LastName, NickName, Email, PhoneNumber, Gender FROM Player WHERE Player.ID = \'' . $playerID . '\'');

	closeDB($db_con);
	return mysqli_fetch_array($db_query_result);
}

function getPlayerTeams($playerID)
{
//TODO sanitize input!
	$db_con = connectToDB();
	$db_query_result = mysqli_query($db_con, 'SELECT P.TeamName, ParkName, DayOfWeek, SeasonDescription FROM ParticipatesIn AS P NATURAL JOIN Roster AS R WHERE R.PlayerID = \'' . $playerID . '\'');

	if ($db_query_result == NULL)
	{
		closeDB($db_con);
		return NULL;
	}

	$result = array();
	while ($row = mysqli_fetch_array($db_query_result))
	{
		$result[] = $row;
	}

	closeDB($db_con);
	return $result;
}
