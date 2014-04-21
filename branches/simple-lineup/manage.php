<?php
	session_start();
	require_once('common-definitions.php');

	// make sure user is logged in and is a manager of the specified team
	if ( !isLoggedIn() || !in_array($_GET['name'], getUserManagedTeamNames()))
	{
		header('Location: index.php');
		exit(0);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Manage - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="manage-body">
		<div id="container">
			<div id="manage-header">
				<h1>Manage</h1>
			</div> <!-- manage-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="manage-content">
<?php
	$db_con = connectToDB();

//TODO if no name provided and user manages more than one team, show a list
	if (isset($_GET['name']))
	{
		$escapedTeamName = mysqli_real_escape_string($db_con, $_GET['name']);
		$team_query_result = mysqli_query($db_con, "SELECT TeamName, PriColor, SecColor, Motto FROM Team WHERE TeamName = '$escapedTeamName'");
//DEBUG
//TODO do better error handling here
if ( !$team_query_result || mysqli_num_rows($team_query_result) == 0)
	error_log('No info was found for team \''. $escapedTeamName . '\' in the database.');
//END DEBUG

		$teamInfo = mysqli_fetch_array($team_query_result);
?>
				<img title="<?= $teamInfo['TeamName'] ?>" src="images/team-no-image.png" />
				<h2><span style="color: #<?= $teamInfo['PriColor'] ?>; background-color: #<?= $teamInfo['SecColor'] ?>"><?= $teamInfo['TeamName'] ?></span></h2>
				<p><?= $teamInfo['Motto'] ?></p>
				<p><a href="roster.php?name=<?= urlencode($teamInfo['TeamName']) ?>">View Rosters</a><br />
				    <a href="#">View lineups for next games</a></p>
<?php
	}

	closeDB($db_con);

	include('includes/footer.php');
?>
			</div> <!-- manage-content -->
		</div> <!-- container -->
	</body>
</html>
