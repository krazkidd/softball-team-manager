<?php
	require_once("common-definitions.php");
?>
<div id="login-module">
<?php

	if (isLoggedIn())
	{
?>
		<p>Hello, <?= getLoginName() ?>!<br>
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
