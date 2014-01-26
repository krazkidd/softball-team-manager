<?php
//TODO how come adding "/" or "../" to this causes breakage? */
	require_once('common-definitions.php');
?>
<div id="navbar">
	<ul>
		<li><a href="/index.php" title="Home">Home</a></li>
		<!-- <li<?= !isLoggedIn() ? ' class="navNotLoggedIn"' : "" ?>><a href="/roster.php">Roster</a></li> -->
		<?= isLoggedIn() ? '<li><a href="/team-profile.php">My Teams</a></li>' : "" ?>
		<li><a href="/calendar.php">Calendar</a></li>
		<li><a href="/about.php" title="About this site">About</a></li>
		<li><a href="/help.php" title="How to use this site">Help</a></li>
	</ul>

	<p id="navLoginName"><?= isLoggedIn() ? "You are logged in as " . getLoginName() . ". <a href=\"/logout.php\" title=\"Log out\">Log out</a>"
	                                      : "You are not logged in. <a href=\"/login.php\" title=\"Log in or Register\">Log in or Register</a>"
	                     ?></p>
</div>
