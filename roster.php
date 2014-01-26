<?php
	session_start();
	require_once('common-definitions.php');

	if (!isLoggedIn())
	{
		header('Location: index.php');
		quit(0);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Roster - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
<?php
	require_once('roster-common-functions.php');
?>
	</head>

	<body id="roster-body">
		<div id="container">
			<div id="roster-header">
				<h1>Roster</h1>
			</div>

<?php
	include('includes/navbar.php');
?>

			<div id="roster">
<p>BROKEN</p>
<?php
	/*$db_con = connectToDB();
	// get this user's teams for the preferred season
//TODO the teams table should have a manager column that is a foreign key to the user/login table. then i could get all teams with the manager who is the currently logged-in user
//TODO need a way to order by dayOfWeek, but not alphabetically... Can I specify an order?
	$db_team_query_result = mysqli_query($db_con, "SELECT teamID FROM teams JOIN leagues ON teams.associatedLeague = leagues.LeagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE name = '" . getUserTeamName() . "' AND seasonID = '" . getUserSeasonID() . "'");
//DEBUG
if ($db_team_query_result == NULL)
	echo "<p class=\"db-error\">Team query result was NULL :(</p>";
//END DEBUG

	while ($teamRow = mysqli_fetch_array($db_team_query_result))
	{
		displayRosterTable($teamRow['teamID']);
	}

	closeDB($db_con);*/
?>
			</div> <!-- roster -->

			<!-- <div id="form-edit-roster">
				<form action="edit-roster.php" method="post">
					COMMENTOUT <input type="submit" name="addplayer" value="Add Player" />
					<input type="submit" name="removeplayer" value="Remove Player" /> COMMENTOUT
					<input type="submit" name="edit" value="Edit Roster" />
				</form>
			</div> --> <!-- form-edit-roster -->

			<p><a href="edit-roster.php">Edit Roster &gt; &gt;</a></p>

<?php
	include('includes/footer.php');
?>
		</div> <!-- end container -->
	</body>
</html>
