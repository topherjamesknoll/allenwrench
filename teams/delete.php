<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];

  $mysqli->query("DELETE FROM `teams` WHERE `teams`.`id` = '$team_id'");

  header('Location: ' . ABSPATH . '/index.php');

}
