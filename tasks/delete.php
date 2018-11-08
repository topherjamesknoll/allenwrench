<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['task'])) {

  $task = $_GET['task'];

  $mysqli->query("DELETE FROM `tasks` WHERE `tasks`.`id` = '$task'");

  header('Location: ' . ABSPATH . '/tasks/index.php');

}
