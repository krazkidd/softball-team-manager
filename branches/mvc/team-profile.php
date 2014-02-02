<?php

session_start();

require_once 'models/model.php';

$teamInfo = getTeamInfo($_GET['name']);
$teamName = $teamInfo['TeamName'];
$priColor = $teamInfo['PriColor'];
$secColor = $teamInfo['SecColor'];
$motto = $teamInfo['Motto'];
$missionStatement = $teamInfo['MissionStatement'];
$notes = '';

$mgrInfo = getTeamManagerInfo($_GET['name']);
$mgrID = $mgrInfo['ID'];
$mgrName = $mgrInfo['FirstName'] . ' ' . $mgrInfo['LastName'];

//TODO get current/past leagues
$leagues = NULL;

require 'views/team-profile.php';
