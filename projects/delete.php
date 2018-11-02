<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['projectid']) && isset($_GET['teamid'])) {

  $project_id = $_GET['projectid'];
  $team_id = $_GET['teamid'];

  connect();
  $sql = "DELETE FROM `projects` WHERE `projects`.`id` = '$project_id'";
  mysqli_query($connection, $sql);
  mysqli_close($connection);

  header('Location: ' . ABSPATH . '/projects/index.php?id=' . $team_id);

}
