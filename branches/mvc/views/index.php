<?php $title = 'Home' ?>

<?php ob_start() ?>
	<p>Welcome to the Team Manager BETA website!</p>

	<?php if ( !isLoggedIn()) { ?>
		<?php include 'includes/login-module.php' ?>
	<?php } ?>
<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
