<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Team Profile</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
<?php
	require_once("common-functions.php");
?>
	</head>

	<body id="team-profile-body">
		<div id="team-profile-header">
			<h1>Team Profile</h1>
		</div> <!-- team-profile-header -->

		<div id="team-profile-content">
<?php
	if (isset($_GET['id']))
	{
		$db_con = connectToDB();





//TODO Team Profile page should show current season. put link to see past/all seasons)







//TODO i think this page should show all leagues in current season (and maybe past seaons). so do a query on the name, not ID. (unfortunately, names aren't necessarily unique)
//TODO a single team gets different ID's across leagues/seasons. make that known to the user; provide links to see all leagues the team is in
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

		closeDB($db_con);
	}
	else
//TODO better error msg.
		die('no team id given');
?>
		</div> <!-- team-profile-content -->
	</body>
</html>
