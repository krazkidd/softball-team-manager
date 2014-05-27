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

<?php $title = 'My Teams' ?>

<?php ob_start() ?>

<!--TODO show team colors and small icon; remove list bullets -->
	<?php if ($managedTeamsList) { ?>
		<p>Teams I manage (click to go to team's management interface):</p>
		<p>
			<ul>
				<?php foreach ($managedTeamsList as $team ) { ?>
					<li><a href="manage.php?name=<?= urlencode($team) ?>"><?= $team ?></a></li>
				<?php } ?>
			</ul>
		</p>
	<?php } ?>
	<?php if ($rosteredTeamsList) { ?>
		<p>Teams I play on (click to go to team's profile):</p>
		<p>
			<ul>
				<?php foreach ($rosteredTeamsList as $team ) { ?>
					<li><a href="team-profile.php?name=<?= urlencode($team) ?>"><?= $team ?></a></li>
				<?php } ?>
			</ul>
		</p>
	<?php } ?>

	<?php if ( !$managedTeamsList && !$rosteredTeamsList) { ?>
		<p>You are not managing or playing on any teams!</p>
	<?php } ?>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
