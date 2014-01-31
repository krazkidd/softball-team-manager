<?php

require_once('common-definitions.php');

function formatPhoneNumber($phoneStr)
{
	if ($phoneStr != NULL)
	{
		if (strlen($phoneStr) == 10)
			return '(' . substr($phoneStr, 0, 3) . ') ' . substr($phoneStr, 3, 3) . '-' . substr($phoneStr, 6, 4);
		else if (strlen($phoneStr) == 7)
			return substr($phoneStr, 0, 3) . '-' . substr($phoneStr, 3, 4);
	}

	return $phoneStr;
}

//TODO this function is not being used--I might just turn into a module
//     How do I turn it into a module? I want to be able to show any player's info, but i need to be able to pass a parameter to do that
function displayPlayerInfo($playerID)
{
	$db_con = connectToDB();

	$db_query_result = mysqli_query($db_con, "SELECT * FROM Player WHERE Player.ID = '$playerID'");

	if ($db_query_result)
	{
		$playerInfo = mysqli_fetch_array($db_query_result);
?>
<div id="player-module">
	<img title="<?= $playerInfo['FirstName'] . " " . $playerInfo['LastName'] ?>" src="/images/player-no-image.gif" />
	<h2 id="player-name-header"><?= $playerInfo['FirstName'] . " " . $playerInfo['LastName'] ?></h2>
	<!-- TODO show nickname? -->
	<!-- <h3>#</h3> TODO shirt number relies on team/league/etc. -->

</div> <!-- player-module -->
<?php
	}

	closeDB($db_con);
}
?>
