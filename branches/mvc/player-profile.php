<?php

session_start();

require_once 'models/model.php';

//TODO redirect to the login page with a message that user can't view a player profile without being logged in
if (!isLoggedIn())
{
	header('Location: index.php');
	exit(0);
}

require_once 'models/player.php';

$playerInfo = getPlayerInfo($_GET['id']);
//TODO if $playerInfo is NULL, then use an $action to show a query failure message

$firstName = $playerInfo['FirstName'];
$lastName = $playerInfo['LastName'];
$nickName = $playerInfo['NickName'];
$phone = $playerInfo['PhoneNumber'] ? formatPhoneNumber($playerInfo['PhoneNumber']) : '[Not Specified]';
$email = $playerInfo['Email'] ? '<a href="mailto:' . $playerInfo['Email'] . '">' . $playerInfo['Email'] . '</a>' : '[Not Specified]';
$gender = $playerInfo['Gender'] ? $playerInfo['Gender'] : '[Not Specified]';

//TODO query DB for teams for teams this player manages or plays on and list them
$teams = getPlayerTeams($_GET['id']);

require 'views/player-profile.php';
