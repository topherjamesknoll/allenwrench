<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>

<?php

session_start();
$_SESSION['user'] = NULL; //destroy all of the session variables
session_destroy();

header('Location:' . ABSPATH . '/auth/login.php');

?>
