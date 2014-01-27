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
	<title>Player Profile - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
<?php
	require_once('player-common-functions.php');
?>
	</head>

	<body id="player-profile-body">
		<div id="container">
			<div id="player-profile-header">
				<h1>Player Profile</h1>
			</div> <!-- player-profile-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="player-profile-content">
<?php
	$db_con = connectToDB();

//TODO sanitize GET param
	$db_query_result = mysqli_query($db_con, "SELECT * FROM Player WHERE Player.ID = ${_GET['id']}");
//DEBUG
// show an error if the query failed
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The query result was NULL :(</p>";
}
//END DEBUG

	$playerInfo = mysqli_fetch_array($db_query_result);
?>
				<img title="<?= $playerInfo['FirstName'] . " " . $playerInfo['LastName'] ?>" src="images/player-no-image.gif" />

				<h2><?= $playerInfo['FirstName'] . " " . $playerInfo['LastName'] ?></h2>
				<?= $playerInfo['NickName'] ? "<h3>\"${playerInfo['NickName']}\"</h3>" : "" ?>

				<p><span class="bold">Phone:</span> <?= $playerInfo['PhoneNumber'] ? formatPhoneNumber($playerInfo['PhoneNumber']) : '[Not Specified]' ?><br>
				    <span class="bold">Email:</span> <?= $playerInfo['Email'] ? "<a href=\"mailto:${playerInfo['Email']}\">${playerInfo['Email']}</a>" : '[Not Specified]' ?><br>
				    <span class="bold">Gender:</span> <?= $playerInfo['Gender'] ? $playerInfo['Gender'] : '[Not Specified]' ?></p>

<?php
//TODO query DB for teams for teams this player manages or plays on and list them (look further below for initial attempt to do this)
?>
<!--TODO show nickname if exists 
				<p><span class="bold"><?= $playerInfo['FirstName'] ?>'s current and past teams:<br />
				    <ul>
					<li> -->
<?php
/*
	// print current/most recent teams in a table
	echo "<div id=\"player_s-teams\">";
	// get today's date	
	//$today = date("Y-m-d");
	// find all rows for the player in the players table. Players are duplicated as seasons pass; that's why this query is ugly.
//TODO need a better way to find the player. Now, we are only checking first and last name. That is not unique enough. Is it okay to keep driver's license #? How about just a hash?
	$db_query_result = mysqli_query($db_con, "SELECT * FROM players AS p1 JOIN players AS p2 ON p1.firstName = p2.firstName AND p1.lastName = p2.lastName JOIN teams ON p2.associatedTeam = teams.teamID JOIN leagues ON teams.associatedLeague = leagues.leagueID JOIN seasons ON leagues.associatedSeason = seasonID WHERE p1.playerID = " . $playerID);
	$tableHeaderMustBePrinted = true;
	while ($row = mysqli_fetch_array($db_query_result))
	{
//TODO it might be best if I just have a global variable for the current/next season
//Previously, I wanted to have a function to find the latest season the player was playing in. I can still do that.
		if ($row['seasonID'] == 1)
		{
			if ($tableHeaderMustBePrinted)
			{
				$tableHeaderMustBePrinted = false;		
				echo "<p class=\"bold\">Currently playing in these divsions:</p>";
				echo "<table><tr><th>Season</th><th>Division</th><th>Class</th><th>Park</th><th>Team</th></tr>";
			}

//TODO needs a day-of-week column
			echo "<tr><td class=\"spring13\">" . $row['description'] . "</td><td>" . $row['division'] . "</td><td>" . $row['class'] . "</td><td>" . $row['park'] . "</td><td>" . $row['name'] . "</td></tr>";
		}
	}

	// only close table if needed
	if ( !$tableHeaderMustBePrinted)
		echo "</table>";

	echo "</div> <!-- player_s-teams -->";
*/

	closeDB($db_con);


	include('includes/footer.php');
?>
			</div> <!-- player-profile-content -->
		</div> <!-- end container -->
	</body>
</html>
