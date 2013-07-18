<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<!-- TODO show game info in title -->
		<title>Field Layout</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" /> 
<?php
	require_once("common-definitions.php");
?>
	</head>

	<body id="field-layout-body">
		<div id="field-layout-header">
			<h1>Field Layout</h1>
		</div>

<?php
//TODO get next game data (or user-select game from GET/POST) 
//TODO get list of players in that game
	$db_con = connectToDB();

//TODO check GET or POST for a game ID. if nothing, redirect to calendar? or just show a table? or pick next game?
	if (isset($_GET['gameid']) && isset($_GET['teamid']))
	{
//ERROR I need a table to track game lineups!! fix query below
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
		//ERROR do switch block here, use css classes from google stuff
	}

	closeDB($db_con);
}

?>


<?php
//ERROR this is temporary
//TODO can i still use integer indices? also, i don't need to tack on extra players if they don't exist, do i? but i should at least be able to handle the case where there are only 9 players
$playerNames = array(
                 "P" => "Pitcher",
                 "C" => "Catcher",
                 "1B" => "First Baseman",
                 "2B" => "Second Baseman",
                 "3B" => "Third Baseman",
                 "SS" => "Short Stop",
                 "LF" => "Left Field",
                 "LC" => "Left Center",
                 "RF" => "Right Field",
                 "RC" => "Right Center",
                 "EP1" => "Extra Player",
                 "EP2" => "Extra Player",
                 "EP3" => "Extra Player",
                 "EP4" => "Extra Player",
                 "EP5" => "Extra Player",
               );
?>
		<div id="softballField">
			<div id="gameInfo">
				<p>TODO next game data here</p>
			</div>

			<div id="pitcher" class="playerPos">
				<p><?= $playerNames["P"]; ?></p>
			</div>

			<div id="catcher" class="playerPos">
				<p><?= $playerNames["C"]; ?></p>
			</div>

			<div id="firstBaseman" class="playerPos">
				<p><?= $playerNames["1B"]; ?></p>
			</div>

			<div id="secondBaseman" class="playerPos">
				<p><?= $playerNames["2B"]; ?></p>
			</div>

			<div id="thirdBaseman" class="playerPos">
				<p><?= $playerNames["3B"]; ?></p>
			</div>

			<div id="shortstop" class="playerPos">
				<p><?= $playerNames["SS"]; ?></p>
			</div>

			<div id="leftFielder" class="playerPos">
				<p><?= $playerNames["LF"]; ?></p>
			</div>

			<div id="centerFielder" class="playerPos">
				<p><?= $playerNames["LC"]; ?></p>
			</div>

			<div id="rightFielder" class="playerPos">
				<p><?= $playerNames["RF"]; ?></p>
			</div>

			<div id="rover" class="playerPos">
				<p><?= $playerNames["RC"]; ?></p>
			</div>
		</div>
	</body>
</html>

