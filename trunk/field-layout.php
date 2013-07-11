<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show game info in title -->
		<title>Field Layout</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="field-layout-body">
		<div id="field-layout-header">
			<h1>Field Layout</h1>
		</div>

look up stuff from Google Drive scripts


<?php
	// create db connection
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs") or die(mysqli_error());

//TODO check GET or POST for a game ID. if nothing, redirect to calendar? or just show a table? or pick next game?
	if (isset($_GET['gameid']) && isset($_GET['teamid']))
	{
ERROR I need a table to track game lineups!! fix query below
		//$db_team_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN teamsgames .homeTeam = teams.teamID OR games.visitingTeam = teams.teamID");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

	// iterate through each row of the result
	while ($row = mysqli_fetch_array($db_query_result))
	{
		ERROR do switch block here, use css classes from google stuff
	}

//TODO Do I really *not* have to close the connection?
	mysqli_close($db_con);
}

?>

	</body>
</html>

