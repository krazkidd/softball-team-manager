<?php $title = 'Home' ?>

<?php ob_start() ?>
	<p>Welcome to the Team Manager BETA website!</p>
<!--TODO show login-module or another login button -->
<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
