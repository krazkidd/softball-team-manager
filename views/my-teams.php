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
