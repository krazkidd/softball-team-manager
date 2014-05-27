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

<?php $title = 'Manage' ?>

<?php ob_start() ?>

<?php if ($action == 'show-team') { ?>
	<img title="<?= $teamInfo['TeamName'] ?>" src="images/team-no-image.png" />
	<h2><span style="color: #<?= $teamInfo['PriColor'] ?>; background-color: #<?= $teamInfo['SecColor'] ?>"><?= $teamInfo['TeamName'] ?></span></h2>
	<p><?= $teamInfo['Motto'] ?></p>
	<p><a href="roster.php?name=<?= urlencode($teamInfo['TeamName']) ?>">View Rosters</a><br />
	    <a href="#">View lineups for next games</a></p>
<?php }	else { // $action == 'show-list' ?>
	<?php if ($managedTeamsList) { ?>
		<p>Which team do you want to manage?</p>
		<p>
			<ul>
				<?php foreach ($managedTeamsList as $team ) { ?>
					<li><a href="manage.php?name=<?= urlencode($team) ?>"><?= $team ?></a></li>
				<?php } ?>
			</ul>
		</p>
	<?php } else { ?>
		<p>You are not a manager of any teams.</p>
	<?php } ?>
<?php
	}

	$content = ob_get_clean();
?>

<?php require 'templates/layout.php' ?>
