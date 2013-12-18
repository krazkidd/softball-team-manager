<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Team Profile</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
<?php
	require_once("common-definitions.php");
?>
	</head>

	<body id="team-profile-body">
		<div id="team-profile-header">
			<h1>Team Profile</h1>
		</div> <!-- team-profile-header -->

		<div id="team-profile-content">
<?php
	$db_con = connectToDB();

//TODO use different variable name
	if (isset($_GET['id']))
	{

		$db_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN leagues ON teams.associatedLeague = leagues.leagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE teams.teamID = {$_GET['id']}");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
	echo "<p class=\"db-error\">The result was NULL :(</p>";
//END DEBUG

		$teamInfo = mysqli_fetch_array($db_query_result);

		echo "<img title=\"" . $teamInfo['name'] . "\" src=\"images/team-no-image.png\" />";
		echo "<h2 id=\"team-name-header\">" . $teamInfo['name'] . "</h2>";
		echo "<p>League Info:</p>";
		echo "<ul><li>Season: {$teamInfo['description']}</li>";
		echo "<li>Division: {$teamInfo['division']}</li>";
		echo "<li>Class: {$teamInfo['class']}</li>";
		echo "<li>Park: {$teamInfo['park']}</li>";
		echo "<li>Field: #{$teamInfo['field']}</li>";
		echo "<li>Day: {$teamInfo['dayOfWeek']}</li></ul>";

	}
	// if no ID given, give the user a choice
	else if (isLoggedIn())
	{
//TODO this query was copied from roster.php, so it has the same problem: the teams table should have a manager column that is a foreign key to the user/login table. then i could get all teams with the manager who is the currently logged-in user
		$db_my_teams_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN leagues ON teams.associatedLeague = leagues.LeagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE name = '" . getUserTeamName() . "' AND seasonID = '" . getUserSeasonID() . "'");
//DEBUG
if ($db_my_teams_query_result == NULL)
	echo "<p class=\"db-error\">Team query result was NULL :(</p>";
//END DEBUG
?>
		<p>Select one of your teams:<br>
		<ul>
<?php
		$thisFile = $_SERVER["PHP_SELF"];
		$parts = Explode('/', $thisFile);
		$thisFile = $parts[count($parts) - 1];

		while ($teamRow = mysqli_fetch_array($db_my_teams_query_result))
		{
?>
			<li><a href="<?= $thisFile ?>?id=<?= $teamRow["teamID"] ?>"><?= $teamRow["name"] ?></a> - <?= $teamRow["division"] . " " . $teamRow["class"] . " @ " . $teamRow["park"] . " #" . $teamRow["field"] . " on " . $teamRow["dayOfWeek"] ?></li>
<?php
		}
?>
		</ul>
		</p>
<?php
		$db_other_teams_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN leagues ON teams.associatedLeague = leagues.LeagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE NOT name = '" . getUserTeamName() . "' AND seasonID = '" . getUserSeasonID() . "'");
		if ($db_other_teams_query_result)
		{
?>
		<p>Or one of the other teams in any of your leagues this season:<br>
		<ul>
<?php
			while ($teamRow = mysqli_fetch_array($db_other_teams_query_result))
			{
?>
			<li><a href="<?= $thisFile ?>?id=<?= $teamRow["teamID"] ?>"><?= $teamRow["name"] ?></a> - <?= $teamRow["division"] . " " . $teamRow["class"] . " @ " . $teamRow["park"] . " #" . $teamRow["field"] . " on " . $teamRow["dayOfWeek"] ?></li>
<?php
			}
?>
		</ul>
		</p>
<?php
		}
	}
	else
	{
?>
		<p>You provided no team ID nor are you logged in. I could give you a list of teams to choose from but am too lazy to do that right now.</p>
<?php
	}

	closeDB($db_con);
?>
		</div> <!-- team-profile-content -->
	</body>
</html>
