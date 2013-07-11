<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show game info in title -->
	<title>Game Info</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>

	<body id="game-info-body">
		<div id="game-info-header">
			<h1>Game Info</h1>
		</div>
<?php
//TODO check GET or POST for a game ID. if nothing, redirect to calendar? or just show a table? or pick next game?

	// create db connection
//TODO don't use die()
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs") or die(mysqli_error());

ERROR parse date from URL
	$date = 

	// check if a whole night is requested or just a single game
//TODO to be more robust, i should prioritize gameid over date, i.e. ignore date if gameid is present
	if (!isset($_GET['gameid']))
	{
		$db_game_info_query_result = mysqli_query($db_con, "SELECT gameID, WHAT_ELSE FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE gameID = {$_GET['gameid']}");
		$db_team_info_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN games ON games.homeTeam = teams.teamID OR games.visitingTeam = teams.teamID");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

PRINT TABLE? no, it's only one row. try doing two columns with more data like Record (W-L)
		echo "<div class=\"home-team\">";
		ERROR echo home team info
		
		echo "<div class=\"visiting-team\">";
		ERROR echo visiting team info
	}
	else if (isset($_GET['date']))
	{
		$db_query_result = mysqli_query($db_con, "SELECT gameID, WHAT_ELSE FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE date = $date ORDER BY time");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG

		echo "<table><tr><th>Time</th><th>Home Team</th><th>Visiting Team</th>";
//TODO if date/time of game is passed, show result
		//if ...
		//	"echo <th>Final Home Score</th><th>Final Visiting Score</th>";
		echo "</tr>";

		for ($row in mysqli_fetch_array($db_query_result))
		{
			$thisFile = $_SERVER["PHP_SELF"];
			$parts = Explode('/', $thisFile);
			$thisFile = $parts[count($parts) - 1];
//TODO make every row element a link?
			echo "<tr><td><a href=\"" . $thisFile . "?gameid={$row['gameid']\">{$_GET['time']}</a></td><td>{$_GET['homeTeam']}</td><td>{$_GET['visitingTeam']}</td></tr>";
		}

		
	}
	else
//TODO don't use die(), and close the db if needed
		die("I need a gameid.");

//TODO Do I really *not* have to close the connection?
	mysqli_close($db_con);
}

?>

	</body>
</html>
