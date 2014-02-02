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
