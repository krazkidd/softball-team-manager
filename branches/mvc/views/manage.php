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
				<?php foreach ($team as $managedTeamsList) { ?>
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
