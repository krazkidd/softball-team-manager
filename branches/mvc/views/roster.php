<?php $title = 'Roster' ?>

<?php ob_start() ?>

	<?php if ($action == 'show-roster') { ?>
<!--TODO show team info -->
		<table>
			<tr>
				<th>#</th>
				<th>Name</th>
			</tr>
			<?php foreach ($roster as $player) { ?>
				<tr>
					<td><?php echo $player['ShirtNum'] ?></td>
					<td><a href="player-profile.php?id=<?= $player['FirstName'] . ' ' . $player['LastName'] ?>"><?= $player['FirstName'] . ' ' . $player['LastName'] ?></a></td>
				</tr>
			<?php } ?>
		</table>
	<?php } else if ($action == 'show-team-list') { ?>
<!--TODO if a name is shown but other parameters are missing, show a list of seasons/leagues -->
<!--TODO show a list of managed teams instead of error msg. -->
		<p class="error">No team selected.</p>
	<?php } ?>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
