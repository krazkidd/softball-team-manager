<?php $title = 'Logout' ?>

<?php ob_start() ?>
	
<?php if ($action == 'logout-success') { ?>
	<p class="success-msg">You were successfully logged out!</p>

	<p>You may close your browser window now.</p>
<?php }	else { ?>
	<p class="error">There was some kind of error.</p>
<?php } ?>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
