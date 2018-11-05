<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['task'])) {

  $task = $_GET['task'];

  connect();
  $sql = "DELETE FROM `tasks` WHERE `tasks`.`id` = '$task'";
  mysqli_query($connection, $sql);
  mysqli_close($connection);

  header('Location: ' . ABSPATH . '/tasks/index.php');

}
