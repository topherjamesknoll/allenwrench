<?php

// This file switches the team and project then redirects

require_once 'config.php';

$team = $_GET['team'];
$project = $_GET['project'];
$directory = $_GET['directory'];

session_start();
$_SESSION['team'] = $team;
$_SESSION['project'] = $project;

header('Location: ' . ABSPATH . $directory);

?>
