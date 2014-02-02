<?php $title = 'Team Profile' ?>

<?php ob_start() ?>

	<img title="<?= $teamName ?>" src="images/team-no-image.png" />
	<h2><span style="color: #<?= $priColor ?>; background-color: #<?= $secColor ?>"><?= $teamName ?></span></h2>
	<h4>Motto</h4>
	<p><?= $motto ?></p>
	<h4>Mission Statement</h4>
	<p><?= $missionStatement ?></p>
	<!-- <h6>Notes</h6>
	<p><?= $notes ?></p> -->
	<?php if (isLoggedIn()) { ?>
		<p>Manager: <a href="player-profile.php?id=<?= $mgrID ?>"><?= $mgrName ?></a></p>
	<?php } ?>

	<?php if ($leagues) { ?>
		<p><?php echo $teamName ?> have played in these leagues:<br />
			<ul>
				<?php foreach ($leagues as $league) { ?>
					<li>TODO</li>
				<?php } ?>
			</ul>
		</p>
	<?php } ?>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
