<?php
	session_start();
	require_once('common-definitions.php');

	if (!isLoggedIn())
	{
		header("Location: index.php");
		quit(0);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>My Teams - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="team-profile-body">
		<div id="container">
			<div id="my-teams-header">
				<h1>My Teams</h1>
			</div> <!-- my-teams-header -->

<?php
	include('includes/navbar.php');
?>

				<div id="my-teams-content">
<?php
	$db_con = connectToDB();

//TODO order by season start date. show old seasons differently.
	$manages_query_result = mysqli_query($db_con, 'SELECT * FROM Team AS T JOIN Player AS P ON T.ManagerID = P.ID JOIN User AS U ON P.ID = U.PlayerID');

	if ($manages_query_result != NULL)
	{
?>
					<h4>Teams I manage:</h4>

					<ul>
<?php
		while ($teamRow = mysqli_fetch_array($manages_query_result))
		{
			$escapedTeamName = mysqli_real_escape_string($db_con, $teamRow['TeamName']);
//TODO what should this link to? These are *managed* teams. Do I have a team management interface yet?
//     right now, i am just linking to Team Profile
?>
						<li><a href="/team-profile.php?name=<?= $escapedTeamName ?>"><?= $teamRow['TeamName'] ?></a></li>
<?php
		}
?>
					</ul>
<?php
	}

//TODO fix query below to remove teams in manages query (use EXCEPT + above query as subquery--need to be union compatible!)
	//$plays_on_query_result = mysqli_query($db_con, 'SELECT ID, FirstName, LastName FROM Player AS P JOIN Team AS T ON P.ID = T.ManagerID EXCEPT ( ');
	/*if ($db_other_teams_query_result)
	{
?>
					<h4>Teams I play on:</h4>
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
<?php
	}
*/

	closeDB($db_con);

	include('includes/footer.php');
?>
			</div> <!-- team-profile-content -->
		</div> <!-- container -->
	</body>
</html>
