<?php
	require_once('common-definitions.php');
?>
<div id="login-module">
<?php

	if (isLoggedIn())
	{
//TODO apply a different style if we show the logout button, to differentiate it from login button
//TODO does the logout button style even work well? Haven't tested it
?>
	<p>Hello, <?= getLoginName() ?>!<br />
	<a href="logout.php">Logout</a></p>
<?php
	}
	else
	{
?>
	<p><a href="login.php">Login</a></p>
<?php
	}
?>
</div>
