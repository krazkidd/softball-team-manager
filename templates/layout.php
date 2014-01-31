<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $title . ' - ' . $PROJECT_NAME ?></title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/styles/style.css" /> 
	</head>

	<body>
		<div id="container">
			<div id="header">
				<h1><?php echo $title ?></h1>
			</div>

			<div id="navbar">
				<ul>
					<li><a href="/index.php" title="Home">Home</a></li>
					<!-- <li<?= !isLoggedIn() ? ' class="navNotLoggedIn"' : "" ?>><a href="/roster.php">Roster</a></li> -->
					<?= isLoggedIn() ? '<li><a href="/my-teams.php">My Teams</a></li>' : "" ?>
					<li><a href="/calendar.php">Calendar</a></li>
					<li><a href="/about.php" title="About this site">About</a></li>
					<li><a href="/help.php" title="How to use this site">Help</a></li>
				</ul>

				<p id="navLoginName"><?= isLoggedIn() ? 'You are logged in as ' . getLoginName() . '. <a href="/logout.php" title="Log out">Log out</a>'
								      : 'You are not logged in. <a href="/login.php" title="Log in or Register">Log in or Register</a>'
						     ?></p>
			</div>

			<?php echo $content ?>

			<div id="footer">
				<p><a href="/index.php">Home</a></p>
				<p>Copyright &copy; 2014. Website design by Mark Ross.</p>
			</div>
		</div>
	</body>
</html>
