<?php $title = 'Help' ?>

<?php ob_start() ?>

	<p>The calendar function is broken.</p>

    <p>You can log in as 'jimbean' with password 'password'. This user is the manager of a team, so
    you can see what a manager sees.</p>

    <p>You can register as a new user but can't do much managing yet.</p>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
