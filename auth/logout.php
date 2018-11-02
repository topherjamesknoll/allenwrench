<?php require_once '../config.php'; ?>

<?php

session_start();
$_SESSION['user'] = NULL; //destroy all of the session variables
session_destroy();

header('Location:' . ABSPATH . '/auth/login.php');

?>
