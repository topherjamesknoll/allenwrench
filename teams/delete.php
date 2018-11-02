<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];

  connect();
  $sql = "DELETE FROM `teams` WHERE `teams`.`id` = '$team_id'";
  mysqli_query($connection, $sql);
  mysqli_close($connection);

  header('Location: ' . ABSPATH . '/index.php');

}
