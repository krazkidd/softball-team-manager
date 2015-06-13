<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- *************************************************************************

  This file is part of Team Manager.

  Copyright © 2013 Mark Ross <krazkidd@gmail.com>

  Team Manager is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  Team Manager is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with Team Manager.  If not, see <http://www.gnu.org/licenses/>.
  
************************************************************************* -->

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $title . ' - ' . PROJECT_NAME ?></title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" /> 
	</head>

	<body>
		<div id="container">
			<div id="header">
				<h1><?php echo $title ?></h1>
			</div>

			<div id="navbar">
				<ul>
					<li><a href="/index.php" title="Home">Home</a></li>
					<?= isLoggedIn() ? '<li><a href="/my-teams.php">My Teams</a></li>' : "" ?>
					<li><a href="/calendar.php">Calendar</a></li>
					<li><a href="/about.php" title="About this site">About</a></li>
					<li><a href="/help.php" title="How to use this site">Help</a></li>
				</ul>

				<p id="navLoginName">
					<?php if (isLoggedIn()) { ?>
						You are logged in as <?php echo getLoginName() ?>. <a href="/logout.php" title="Log out">Log out</a>
					<?php } else { ?>
						You are not logged in. <a href="/login.php" title="Log in or Register">Log in or Register</a>
					<?php } ?>
				</p>
			</div>

			<div id="content">
				<?php echo $content ?>
			</div>

			<div id="footer">
				<p><a href="/index.php">Home</a></p>
				<p>Copyright &copy; 2013. Website design by Mark Ross.</p>
			</div>
		</div>
	</body>
</html>
