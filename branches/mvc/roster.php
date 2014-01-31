<?php
	session_start();
	require_once('common-definitions.php');

	if (!isLoggedIn())
	{
		header('Location: index.php');
		quit(0);
	}

	require_once('roster-common-functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Roster - Team Manager</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="roster-body">
		<div id="container">
			<div id="roster-header">
				<h1>Roster</h1>
			</div>

<?php
	include('includes/navbar.php');
?>

			<div id="roster-content">
<?php
	if (isset($_GET['name']))
	{
		$db_con = connectToDB();

		$escapedTeamName = mysqli_real_escape_string($db_con, $_GET['name']);
		$roster_query_result = mysqli_query($db_con, "SELECT DISTINCT TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription FROM Roster WHERE TeamName = '$escapedTeamName' ORDER BY SeasonDescription");
//DEBUG
if ( !$roster_query_result)
	error_log("Roster query result was NULL");
//END DEBUG
?>
				<ul>
<?php
		while ($leagueRow = mysqli_fetch_array($roster_query_result))
		{
?>
					<!-- TODO fix this: <li><a href="roster.php?name=<? $_GET['name'] ?>& -->
					<li><a href="#">TODO</a></li>
<?php
		}
?>
				</ul>

<?php
		closeDB($db_con);
	}
?>
			</div> <!-- roster-content -->

<?php
	include('includes/footer.php');
?>
		</div> <!-- end container -->
	</body>
</html>
