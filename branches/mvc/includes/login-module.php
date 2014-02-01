<?php require_once 'models/model.php' ?>

<div id="login-module">
	<?php if ( !isLoggedIn()) { ?>
		<p>Hello, <?php echo getLoginName() ?>!<br />
		    <a href="login.php">Login</a></p>
	<?php } else { ?>
		<p>Hello, <?php echo getLoginName() ?>!<br />
		    <a href="logout.php">Logout</a></p>
	<?php } ?>
</div>
