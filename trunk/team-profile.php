<?php
	session_start();
	require_once('common-definitions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Team Profile - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="team-profile-body">
		<div id="container">
			<div id="team-profile-header">
				<h1>Team Profile</h1>
			</div> <!-- team-profile-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="team-profile-content">
<?php
	$db_con = connectToDB();

	if (isset($_GET['name']))
	{
		$escapedTeamName = mysqli_real_escape_string($db_con, $_GET['name']);
		$team_query_result = mysqli_query($db_con, "SELECT * FROM Team WHERE TeamName = '$escapedTeamName'");
		$mgr_query_result = mysqli_query($db_con, "SELECT ID, FirstName, LastName FROM Player AS P JOIN Team AS T ON P.ID = T.ManagerID WHERE TeamName = '$escapedTeamName'");
//DEBUG
if ( !$team_query_result)
	error_log('No info was found for team \''. $escapedTeamName . '\' in the database.');
//END DEBUG

		$teamInfo = mysqli_fetch_array($team_query_result);
		$mgrInfo = mysqli_fetch_array($mgr_query_result);
?>
				<img title="<?= $teamInfo['TeamName'] ?>" src="images/team-no-image.png" />
				<h2><span style="color: #<?= $teamInfo['PriColor'] ?>; background-color: #<?= $teamInfo['SecColor'] ?>"><?= $teamInfo['TeamName'] ?></span></h2>
				<h4>Motto</h4>
				<p><?= $teamInfo['Motto'] ?></p>
				<h4>Mission Statement</h4>
				<p><?= $teamInfo['MissionStatement'] ?></p>
				<h6>Notes</h6>
				<p><?= $teamInfo['Notes'] ?></p>
<?php
		if (isLoggedIn())
		{
?>
				<p>Manager: <a href="player-profile.php?id=<?= $mgrInfo['ID'] ?>"><?= $mgrInfo['FirstName'] . " " . $mgrInfo['LastName'] ?></a></p>
<?php
		}
?>
		
<!--	TODO list current leagues (that is, leagues that have started that this team participates in
		echo "<p>League Info:</p>";
		echo "<ul><li>Season: {$teamInfo['description']}</li>";
		echo "<li>Division: {$teamInfo['division']}</li>";
		echo "<li>Class: {$teamInfo['class']}</li>";
		echo "<li>Park: {$teamInfo['park']}</li>";
		echo "<li>Field: #{$teamInfo['field']}</li>";
		echo "<li>Day: {$teamInfo['dayOfWeek']}</li></ul>"; -->
<?php
	}
	// if no team name is given, show a list of teams the logged in user is on
//TODO how do I determine user's teams?
/*	else if (isLoggedIn())
	{
//TODO this query was copied from roster.php, so it has the same problem: the teams table should have a manager column that is a foreign key to the user/login table. then i could get all teams with the manager who is the currently logged-in user
		$db_my_teams_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN leagues ON teams.associatedLeague = leagues.LeagueID JOIN seasons ON leagues.associatedSeason = seasons.seasonID WHERE name = '" . getUserTeamName() . "' AND seasonID = '" . getUserSeasonID() . "'");
//DEBUG
if ($db_my_teams_query_result == NULL)
	echo "<p class=\"db-error\">Team query result was NULL :(</p>";
//END DEBUG
?>
				<p>Select one of your teams:<br />
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
*/
	else
	{
		$teams_query_result = mysqli_query($db_con, "SELECT TeamName FROM Team ORDER BY TeamName");

		if ( !$teams_query_result || mysqli_num_rows($teams_query_result) == 0) {
//TODO do better error handling here
?>
				<p class="db-error">There are no teams in the database. Hm.</p>
<?php
		}
		else {
?>
				<p>You provided no team name nor are you logged in. Try selecting a team from this list:</p>

				<form action="team-profile.php" method="get">
					<select name="name">
<?php
			while ($row = mysqli_fetch_array($teams_query_result)) {
//TODO it appears here that forms automatically URL encode the values. is that right?
?>
						<option value="<?= $row["TeamName"] ?>"><?= $row["TeamName"] ?></option>
<?php
			}
?>
					</select>

					<input type="submit" value="Go">
				</form>
<?php
		}
	}

	closeDB($db_con);

	include('includes/footer.php');
?>
			</div> <!-- team-profile-content -->
		</div> <!-- container -->
	</body>
</html>
