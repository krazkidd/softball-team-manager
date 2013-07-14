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

		<p><a href="field-layout.php">View Field Layout &gt; &gt;</a></p>
<?php
//TODO check GET or POST for a game ID. if nothing, redirect to calendar? or just show a table? or pick next game?

	// create db connection
//TODO don't use die()
	$db_con = mysqli_connect("localhost", "OddAdmin", "OddPass", "oddballs") or die(mysqli_error());

	// check if a whole night is requested or just a single game
//TODO to be more robust, i should prioritize gameid over date, i.e. ignore date if gameid is present
	if (isset($_GET['gameid']))
	{
		$db_game_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE gameID = {$_GET['gameid']}");
		$db_team_info_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN games ON games.homeTeam = teams.teamID OR games.visitingTeam = teams.teamID");
//DEBUG
// show an error if either of the queries failed
if ($db_game_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The game info result was NULL :(</p>";
}
if ($db_team_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The team info result was NULL :(</p>";
}
//END DEBUG

//TODO PRINT TABLE? no, it's only one row. try doing two columns with more data like Record (W-L)
//TODO print home and visiting team info
		echo "<div class=\"home-team\">TODO</div>";
		
		echo "<div class=\"visiting-team\">TODO</div>";
	}
	else
//TODO don't use die(), and close the db if needed
		die("I need a gameid.");

//TODO Do I really *not* have to close the connection?
	mysqli_close($db_con);

?>

	</body>
</html>
