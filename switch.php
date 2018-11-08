<?php

// This file switches the team and project then redirects

if (file_exists('config.php')) : require_once 'config.php'; else : header('Location: install.php'); endif;

$team = $_GET['team'];
$project = $_GET['project'];
$directory = $_GET['directory'];

session_start();
$_SESSION['team'] = $team;
$_SESSION['project'] = $project;

header('Location: ' . ABSPATH . $directory);

?>
