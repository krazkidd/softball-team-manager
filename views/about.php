<?php $title = 'About' ?>

<?php ob_start() ?>

	<p>You can manage your team with this website.</p>
	<p>Eventually, there will be an Android app, too!</p>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
