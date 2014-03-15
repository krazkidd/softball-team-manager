<?php $title = 'Help' ?>

<?php ob_start() ?>

	<p>I should probably mention how to actually use the site here.</p>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
