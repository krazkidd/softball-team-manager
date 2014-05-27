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

<?php $title = 'Player Profile' ?>

<?php ob_start() ?>

	<img title="<?= $firstName . ' ' . $lastName ?>" src="images/player-no-image.gif" />

	<h2><?= $firstName . ' ' . $lastName ?></h2>
	<?= $nickName ? '<h3>"' . $nickName . '"</h3>' : '' ?>

	<p><span class="bold">Phone:</span> <?= $phone ?><br />
	    <span class="bold">Email:</span> <?= $email ?><br />
	    <span class="bold">Gender:</span> <?= $gender ?></p>

<!--TODO show nickname below if it exists -->
	<p><?= $firstName ?>'s current and past teams:<br />
		<ul>
			<?php foreach ($teams as $team) { ?>
<!--TODO need to escape team name string, right? -->
				<li><a href="team-profile.php?name=<?= $team['TeamName'] ?>"><?= $team['TeamName'] ?></a></li>
			<?php } ?>
		</ul>
	</p>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
